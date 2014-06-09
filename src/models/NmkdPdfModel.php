<?php

class NmkdPdfModel extends NmkdModel
{

//main function - returns nmkdPdfData array
    public function getNmkdPdfData($discipline)
    {
        
            
        $discData = $this->getAllFromDiscipline($discipline);
        
        $questionsData = $this->getAllFromThemesQuestions($discipline);
        

        $typesData = $this->getTypes();
        

        


        $themes = array(); //array([id]=>name)
        $questions = array(); //array([id_parent]=>name)
        end($questionsData);
        for ($i=0; $i<=key($questionsData); $i++) {
            if (isset($questionsData[$i])) {
                if ($questionsData[$i]['id_parent'] == '') {    
                    $themes[$questionsData[$i]['id_tq']] = $questionsData[$i]['name'];
                } else {
                    $questions[$questionsData[$i]['id_parent']][] = $questionsData[$i]['name'];
                }
            }
            
        }


        foreach ($typesData as $id => $name) {
            $typesDbData[$name] = $this->getAllFromTypes($discipline, $name);

            foreach ($typesDbData[$name] as $row=>$data) {
                $typeQuestionsId[$name][$row] = explode(',',substr($data['questions_for_'.$name],1,-1));
            }
        }

        
        $typeQuestions = array();
        for ($i=0; $i<key($questionsData)+1; $i++) {                        
            foreach ($typesData as $typeId => $type) {
                if (!isset($typeQuestionsId[$type])) {
                    break;
                }
                foreach($typeQuestionsId[$type] as $row=>$idArr) {
                    if (strlen((string)array_search($questionsData[$i]['id_tq'], $idArr)) > 0) {
                        $typeQuestions[$type][$row]['theme'] = $typesDbData[$type][$row]['theme'];
                        $typeQuestions[$type][$row]['semester'] = $typesDbData[$type][$row]['semester'];
                        $typeQuestions[$type][$row]['hours'] = $typesDbData[$type][$row]['hours'];
                        $typeQuestions[$type][$row]['questions'][] = $questionsData[$i]['name'];
                    }
                }
            }
        }

        

        

        foreach ($questionsData as $row=>$data) {
            $questionIdNames[$data['id_tq']] = $data['name'];
        }
        $idDiscipline = 1;
        $modulesDump = $this->getAllFromModules($idDiscipline);
        foreach ($modulesDump as $row=>$data) {
            $themesArr = explode(',',substr($data['themes'],1,-1));
            
            $modulesData[$data['module']] = array_intersect($themesArr, array_keys($questionIdNames));
            foreach ($modulesData[$data['module']] as $key=>$id) {
                $modulesData[$data['module']][$key] = $questionIdNames[$id];
            }
            
        }
        
        

        $res = array();
        $res['disc_name'] = $discData['name'];
        $res['id_direction'] = $discData['id_spec'];
        $res['id_spec'] = $discData['id_subspec'];
        $res['types_data'] = $typesData;
        $res['themes_data'] = $questionsData;
        $res['themes'] = $themes;
        $res['questions'] = $questions;
        $res['type_questions'] = $typeQuestions;
        $res['moduleData'] = $modulesData;

        $res = array_merge(Container::get('params')->getNmkdPdfData(), $res);
        /*echo '<pre>';
        print_r($typeQuestions);
        print_r($typesDbData);
        echo '</pre>';*/
        return $res;
    }

//return row from 'discipline' table where id = $discipline
    private function getAllFromDiscipline($discipline)
    {
        $discQuery = self::$db->prepare('SELECT * FROM discipline WHERE id=:id');
        self::$db->beginTransaction();
            $discQuery->bindValue(':id', $discipline);
            $discQuery->execute();
        self::$db->commit();
        
        return $discQuery->fetchAll(PDO::FETCH_ASSOC)[0];
    }

//return all from 'themes_questions' table where id = $discipline
    private function getAllFromThemesQuestions($discipline)
    {
        $themesQuestionsQuery = self::$db->prepare('SELECT * FROM themes_questions WHERE id_discipline=:id_disc');
        self::$db->beginTransaction();
            $themesQuestionsQuery->bindValue(':id_disc', $discipline);
            $themesQuestionsQuery->execute();
        self::$db->commit();
        
        return $themesQuestionsQuery->fetchAll(PDO::FETCH_ASSOC);
    }

//return all from lection/practical/seminary... tables where id = $discipline
    private function getAllFromTypes($discipline, $currentType)
    {
        $typeQuery = self::$db->prepare("SELECT * FROM $currentType WHERE id_disc=:id_disc");
        self::$db->beginTransaction();
            $typeQuery->bindValue(':id_disc', $discipline);
            $typeQuery->execute();
        self::$db->commit();
        
        return $typeQuery->fetchAll(PDO::FETCH_ASSOC);
    }

//return all from modules table, where discipline
    private function getAllFromModules($idDiscipline)
    {
        $moduleQuery = self::$db->prepare("SELECT * FROM modules WHERE id_disc=:id_disc");

        self::$db->beginTransaction();
            $moduleQuery->bindValue(':id_disc', $idDiscipline);
            $moduleQuery->execute();
        self::$db->commit();

        return $moduleQuery->fetchAll(PDO::FETCH_ASSOC);
    }





    
}
