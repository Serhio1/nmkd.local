<?php

class NmkdModel extends Model
{
    private $questions;

//main function
    public function setAllQuestions($questions)
    {
        $this->questions = $questions;
        $storage = Container::get('static_storage');
        $themes = $storage->get('themes');
        $modules = $storage->get('modules');
        $tqQuery = self::$db->prepare("INSERT INTO themes_questions(name, id_discipline, types_id, num_tq)
                                      VALUES (:name, :id_disc, :types_id, :num_tq) ");
		foreach($questions as $qKey => $question){
			$typesId[$qKey] = $this->getQuestionTypes($qKey);
		}
		$num_tq = 0;
        self::$db->beginTransaction();
		
        $questions = array_diff($questions, array_intersect_key($questions, array_flip($modules))); //cut modules
        
        
            foreach($questions as $qKey => $question){
				if (array_search($qKey, $themes)) {
					$num_tq = 0;
				}
                $tqQuery->bindValue(':name', $question);
                $tqQuery->bindValue(':id_disc', 1);
                $tqQuery->bindValue(':num_tq', $num_tq++);
                $tqQuery->bindValue(':types_id', '{'.implode(',', $typesId[$qKey]).'}');
                $tqQuery->execute();
            }
        self::$db->commit();

		$dump = $this->getLastLoadedQuestions();

		$this->setModules($dump, 1);

		foreach ($this->getIdTypes() as $id => $type) {
			$this->setQuestionsTypes($type, $id);
			$this->setQuestionsForType($type, $dump);
			$this->setIdParent($type, $dump);
		}
    }
  
//returns array of types id => types name from static_storage
    private function getIdTypes()
    {
		$storage = Container::get('static_storage');
		$types = $storage->get('types');
		$typesRows = $this->selectIn('types', 'name', array_keys($types));

		$typesIdName = array();
		foreach ($typesRows as $row) {
			$typesIdName[$row['id']] = $row['name'];
		}

		return $typesIdName;
	}

//return array [id] => name from 'types' table 
	protected function getTypes()
	{
		$typeQuery = self::$db->prepare('SELECT * FROM types');
		self::$db->beginTransaction();
			$typeQuery->execute();
		self::$db->commit();
		$typesDump = $typeQuery->fetchAll(PDO::FETCH_ASSOC);

		$res = array();
		end($typesDump);
		for ($i=0; $i<=key($typesDump); $i++) {
			$res[$typesDump[$i]['id']] = $typesDump[$i]['name'];
		}

		return $res;
	}

//returns array of types id from database for question
	protected function getQuestionTypes($qKey)
	{
		$storage = Container::get('static_storage');
		$types = $storage->get('types');
		$dbTypes = $this->getIdTypes();
		$idArr = array();
		foreach ($types as $name => $data) {
			foreach ($data as $qNum) {
				if ($qKey == $qNum) {
					$idArr[] = array_search($name, $dbTypes);
				}
			}
		}

		return $idArr;
	}

//inserts id_disc,semester,theme into lection/practical/seminary/... 
	private function setQuestionsTypes($currentType)
	{
        $insertTypeQuery = self::$db->prepare("INSERT INTO $currentType(theme, semester, id_disc)
											   VALUES (:theme, :semester, :id_disc)");

		foreach ($this->getTypeThemes($currentType) as $theme) {
			
			if (!$this->themeExists($currentType, $theme)) {
				//insert
				self::$db->beginTransaction();
					$insertTypeQuery->bindValue(':theme', $theme);
					$insertTypeQuery->bindValue(':semester', 1);
					$insertTypeQuery->bindValue(':id_disc', 1);			//todo: id_disc
					$insertTypeQuery->execute();
				self::$db->commit();
			}
		}
        
	}

//if theme exists in current database return true
	private function themeExists($currentType, $theme)
	{
		$selectTypeQuery = self::$db->prepare("SELECT COUNT(*) FROM $currentType
											   WHERE theme=:theme");

		self::$db->beginTransaction();
			$selectTypeQuery->bindValue(':theme', $theme);
			$selectTypeQuery->execute();
		self::$db->commit();

		if (count($selectTypeQuery->fetchAll(PDO::FETCH_ASSOC)) > 0) {
			return false;
		} else {
			return true;
		}
	}

//returns array of themes for current type
	private function getTypeThemes($currentType)
	{
		$res = array();
		$storage = Container::get('static_storage');
		$typeTheme = $storage->get($currentType.'_theme');
		
		$themesKeys = array_unique(array_values($typeTheme));
		$storageThemes = $storage->get('themes');
		$questions = $storage->get('questions');
		foreach ($themesKeys as $key) {
			$res[] = $questions[$storageThemes[$key]];
		}

		return $res;
	}

//updates lection / practical /...  sets questions_for_lection / questions_for.... 
	private function setQuestionsForType($currentType, $dump)
	{
		$storage = Container::get('static_storage');
		$typeTheme = $storage->get($currentType.'_theme');
		$typeTheme = $this->getTypeThemeArray($currentType);
		$q_f_type = 'questions_for_'.$currentType;
		$updateTypeQuery = self::$db->prepare("UPDATE $currentType
											  SET $q_f_type = :questionsArr
											  WHERE theme=:theme");
											
		foreach ($typeTheme as $question=>$theme) {
			$idQuestionToTheme[array_search($question, $dump)] = $theme;
		}

		foreach ($typeTheme as $question=>$theme) {
			$keys = array_keys($idQuestionToTheme, $theme);
			self::$db->beginTransaction();
				$updateTypeQuery->bindValue(':theme', $theme);
				$updateTypeQuery->bindValue(':questionsArr', '{'.implode(',', $keys).'}');
				$updateTypeQuery->execute();
			self::$db->commit();
		}
		
	}

//updates themes_questions, sets id_parent
	private function setIdParent($currentType, $dump)
	{
		$storage = Container::get('static_storage');
		$typeTheme = $storage->get($currentType.'_theme');
		$typeTheme = $this->getTypeThemeArray($currentType);

		$updateThemesQuestoinsQuery = self::$db->prepare("UPDATE themes_questions
														  SET id_parent = :id_parent
														  WHERE name=:name");

		foreach ($typeTheme as $question=>$theme) {
			if ($question != $theme) {
				self::$db->beginTransaction();
					$updateThemesQuestoinsQuery->bindValue(':id_parent', array_search($theme, $dump));
					$updateThemesQuestoinsQuery->bindValue(':name', $question);
					$updateThemesQuestoinsQuery->execute();
				self::$db->commit();
			}
		}
		
	}

//inserts modules data into modules table
	private function setModules($dump, $disciplineId)
	{
		$storage = Container::get('static_storage');
		$modulesNums = $storage->get('modules');
		$questions = $storage->get('questions');
		$themesModules = $storage->get('themes_modules');

		foreach ($themesModules as $theme=>$module) {
			$themesId[$module][] = array_search($questions[$theme] ,$dump);
			$modules[$module] = $questions[$module];
		}

		$moduleQuery = self::$db->prepare("INSERT INTO modules(id_disc, module, themes)
										   VALUES(:id_disc, :module, :themes)");

		self::$db->beginTransaction();
			foreach ($modules as $key=>$module) {
				$moduleQuery->bindValue(':id_disc', $disciplineId);
				$moduleQuery->bindValue(':module', $module);
				if (count($themesId[$key])>1) {
					$moduleQuery->bindValue(':themes', '{'.implode(',',$themesId[$key]).'}');
				} else {
					$moduleQuery->bindValue(':themes', '{'.implode(',',$themesId[$key]).'}');
				}
				$moduleQuery->execute();
			}

			
			
		self::$db->commit();
	}

//return array(['question_name'] => theme_name) from storage
	protected function getTypeThemeArray($currentType)
	{
		$storage = Container::get('static_storage');
		$typeTheme = $storage->get($currentType.'_theme');
		$themes = $storage->get('themes');
		$questions = $storage->get('questions');
		$res = array();
		foreach ($typeTheme as $qNum => $themeNum) {
			$res[$questions[$qNum]] = $questions[$themes[$themeNum]];
		}

		return $res;
	}

	
//return dump of last loaded questions in themes_questions: array([id]=>name)
    private function getLastLoadedQuestions()
    {
        $questions = $this->questions;
        $storage = Container::get('static_storage');
        $lastTqQuery = self::$db->prepare("SELECT id_tq, name
                                         FROM themes_questions
                                         ORDER BY id_tq DESC
                                         LIMIT :qCount");
        self::$db->beginTransaction();
            $lastTqQuery->bindValue(':qCount',count($questions));
            $lastTqQuery->execute();
        self::$db->commit();

        $res = $lastTqQuery->fetchAll(PDO::FETCH_NUM);
        foreach ($res as $key=>$val) {
            $questionIdNames[$res[$key][0]] = $res[$key][1];
        }

        return $questionIdNames;
    }

//save current step of nmkd generation in 'session' table
    public function saveSession($step, $idDiscipline)
    {
		$sessionData = Container::get('static_storage')->getAll();
		$sessionData['step'] = $step;
		
		$sessionQuery = self::$db->prepare("INSERT INTO sessions(session_data, id_disc)
                                      VALUES (:session_data, :id_disc) ");
        self::$db->beginTransaction();
            $sessionQuery->bindValue(':session_data', serialize($sessionData));
            $sessionQuery->bindValue(':id_disc', $idDiscipline);
            $sessionQuery->execute();
        self::$db->commit();

        print_r($sessionData);
	}

	public function getSession($idDiscipline)
	{
		$sessionQuery = self::$db->prepare("SELECT session_data FROM sessions
											WHERE id_disc = :id_disc");
        self::$db->beginTransaction();
            $sessionQuery->bindValue(':id_disc', $idDiscipline);
            $sessionQuery->execute();
        self::$db->commit();

        $res = $sessionQuery->fetchAll(PDO::FETCH_ASSOC);
	
        return unserialize($res['0']['session_data']);
	}

	public function getSessionList()
	{
		$sessionListQuery = self::$db->prepare("SELECT * FROM sessions");//WHERE user_id = :user_id
		$disciplineQuery = self::$db->prepare("SELECT name FROM discipline WHERE id=:id");
			
        self::$db->beginTransaction();
            $sessionListQuery->execute();
        self::$db->commit();
        $res = $sessionListQuery->fetchAll(PDO::FETCH_ASSOC);

        end($res);
		self::$db->beginTransaction();
			for ($i=0; $i<=key($res); $i++) {
				$disciplineQuery->bindParam(':id', $res[$i]['id_disc']);
				$disciplineQuery->execute();
			}
		self::$db->commit();	
		$names = $disciplineQuery->fetchAll(PDO::FETCH_ASSOC);
		
        for ($i=0; $i<=key($res); $i++) {
			$res[$i]['name'] = $names[$i]['name'];
		}
	
        return $res;
	}



	//-------------------------------------------------------------
	public function clearDb()
	{
		$query1 = self::$db->prepare("DELETE FROM control_work_type");
		//$query2 = self::$db->prepare("DELETE FROM discipline");
		$query3 = self::$db->prepare("DELETE FROM individual");
		$query4 = self::$db->prepare("DELETE FROM laboratory");
		$query5 = self::$db->prepare("DELETE FROM lection");
		$query6 = self::$db->prepare("DELETE FROM literature");
		$query7 = self::$db->prepare("DELETE FROM practical");
		$query8 = self::$db->prepare("DELETE FROM self");
		$query9 = self::$db->prepare("DELETE FROM seminary");
		//$query10 = self::$db->prepare("DELETE FROM sessions");
		$query11 = self::$db->prepare("DELETE FROM themes_questions");
		$query12 = self::$db->prepare("DELETE FROM modules");

		self::$db->beginTransaction();
            $query1->execute();
            //$query2->execute();
            $query3->execute();
            $query4->execute();
            $query5->execute();
            $query6->execute();
            $query7->execute();
            $query8->execute();
            $query9->execute();
           // $query10->execute();
            $query11->execute();
            $query12->execute();
        self::$db->commit();

	}
    
}
