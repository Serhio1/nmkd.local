<?php

class NmkdController extends Controller
{
    public function indexAction()
    {
//-------------------------------------------------------
        //unset($_SESSION);
        $model = $this->getModel('nmkd');
        $model->clearDb();
//-------------------------------------------------------
        Container::get('static_storage')->unsetAll();
        
        $errors = array();
        if (isset($_POST['redirectData']['errors'])) {
            $errors = $_POST['redirectData']['errors'];
        }

        return $this->render('nmkd/input.html.twig', array(
            'errors' => $errors,
        ));
    }

    
    public function setThemesAction()
    {
        $errors = array();
        if (isset($_POST['redirectData']['errors'])) {
            $errors = $_POST['redirectData']['errors'];
        }
        
        
        $questionArr = array();
        if (isset($_POST['questions']) && $_POST['questions']) {
            $questionStr = $_POST['questions'];
            $questionArr = explode('<br />', nl2br($questionStr));
            $questionArr = array_map('trim',$questionArr);
            $questionArr = array_values(array_filter($questionArr));
            $this->storage()->set('questions', $questionArr);
        } elseif ($this->storage()->get('questions')) {
            $questionArr = $this->storage()->get('questions');
        } else {
            Container::get('errors')->addError('nmkd', 'no_q_inputet');
            $this->redirect('input', array(
                'errors'=>Container::get('errors')->outErrors(),
            ));
        }

        return $this->render('nmkd/setThemes.html.twig', array(
            'questions' => $questionArr,
            'errors' => $errors,
        ));
    }
    
    public function setModulesAction()
    {
        $errors = array();
        if (isset($_POST['redirectData']['errors'])) {
            $errors = $_POST['redirectData']['errors'];
        }

        
        $questions = $this->storage()->get('questions');
        if (isset($_POST['themes']) && $_POST['themes']=='on') {
            $themes = array();
            foreach($questions as $num=>$question){
                if(isset($_POST[$num])) {
                    $themes[] = $num;
                }
            }
            $this->storage()->set('themes', $themes);
        } elseif ($this->storage()->get('themes')) {
            $themes = $this->storage()->get('themes');
        } else {
            Container::get('errors')->addError('nmkd', 'no_t_selected');
            $this->redirect('set-themes', array(
                'errors' => Container::get('errors')->outErrors(),
            ));
        }

        $resQuestions=array();
        foreach (array_diff(array_keys($questions), $themes) as $key) {
            $resQuestions[$key] = $questions[$key];
        }
        

        return $this->render('nmkd/setModules.html.twig', array(
            'questions' => $resQuestions,
            'errors' => $errors,
        ));
        
        
    }

    public function themesToModulesAction()
    {
        $errors = array();
        if (isset($_POST['redirectData']['errors'])) {
            $errors = $_POST['redirectData']['errors'];
        }

        $questions = $this->storage()->get('questions');
        $themes = $this->storage()->get('themes');

        if (isset($_POST['module']) && $_POST['module']=='on') {        
            $modules = array();
            foreach($questions as $num=>$question){
                if(isset($_POST[$num])) {
                    $modules[] = $num;
                }
            }
            $this->storage()->set('modules', $modules);
            foreach ($modules as $moduleNum) {
                $moduleQuestions[$moduleNum] = $questions[$moduleNum];
            }

            foreach ($themes as $themeNum) {
                $themeQuestions[$themeNum] = $questions[$themeNum];
            }
            
        } elseif ($this->storage()->get('modules')) {
            $modules = $this->storage()->get('modules');
            foreach ($modules as $moduleNum) {
                $moduleQuestions[$moduleNum] = $questions[$moduleNum];
            }
            foreach ($themes as $themeNum) {
                $themeQuestions[$themeNum] = $questions[$themeNum];
            }
        } else {
            Container::get('errors')->addError('nmkd', 'no_m_selected');
            $this->redirect('set-modules', array(
                'errors' => Container::get('errors')->outErrors(),
            ));
        }

        return $this->render('nmkd/themesModules.html.twig', array(
            'themes' => $themeQuestions,
            'modules' => $moduleQuestions,
            'errors' => $errors,
        ));
    }

    
    
    public function setTypesAction()
    {
        $questions = $this->storage()->get('questions');

        $errors = array();
        if (isset($_POST['redirectData']['errors'])) {
            $errors = $_POST['redirectData']['errors'];
        }

        
        $questions = $this->storage()->get('questions');
        $themes = $this->storage()->get('themes');
        $modules = $this->storage()->get('modules');
        
        

        $resQuestions=array();
        $questionsKeys = array_diff(array_keys($questions), $modules);
        foreach (array_diff($questionsKeys, $themes) as $key) {
            $resQuestions[$key] = $questions[$key];
        }

        
        if (isset($_POST['themes_modules']) && $_POST['themes_modules']) {
            $this->storage()->set('themes_modules', $this->getTMArray($_POST['themes_modules']));
        } else {
            Container::get('errors')->addError('nmkd', 'no_tm_connected');
            $this->redirect('themes-modules', array(
                'errors' => Container::get('errors')->outErrors(),
            ));
        }
        
        
        return $this->render('nmkd/setTypes.html.twig', array(
            'questions' => $resQuestions,
            'errors' => $errors
        ));
    }
    
    
    public function questionsToThemesAction($params)
    {

        $types = Container::get('params')->types;
        $currentType = $params[0];
        if ($currentType == $types[count($types)-1]) {
            $nextType = 'save';
        } else {
            $nextType = $types[array_search($currentType, $types)+1];
        }
        $questionList = $this->storage()->get('questions');
        $themesNums = $this->storage()->get('themes');
        
        foreach ($themesNums as $num) {
            $themes[] = $questionList[$num];
        }
        $themes = $this->getValuesByKeys($themesNums, $questionList);
        
        if ($currentType == $types[0]) {
            $this->setTypesToStorage($types);
        }

        $typesQuestions = $this->storage()->get('types');
        if (isset($typesQuestions[$currentType])) {
            $questionsNums = $typesQuestions[$currentType];
        } else {
            if ($currentType != 'save') {
                $this->redirect('questions-themes/'.$nextType);
            }
        }

        if (isset($questionsNums)) {
            $questions = $this->getValuesByKeys($questionsNums, $questionList);
        }

        if (isset($_POST['themes_questions']) && $_POST['themes_questions']) {
            if($currentType == 'save') {
                $prevType = $types[count($types)-1];
            } else {
                $prevType = $types[array_search($currentType, $types)-1];
            }

            
            
        // if there is no questions at this step -> redirect to next step
            if ($_POST['themes_questions'] == NULL) {
                return $this->redirect('questions-themes/'.$currentType);
            }
            
            $questionTheme = $this->getQTArray(
                                    $_POST['themes_questions'],
                                    $prevType);
            
            $this->storage()->set($prevType.'_theme',$questionTheme);
        } else {
    // if first iteration
            /*if (!isset($_POST['type']) || $_POST['type'] == NULL) {
                Container::get('errors')->addError('nmkd','no_q_selected');
                
                return $this->redirect('set-types',array(
                        'errors' => Container::get('errors')->outErrors()
                ));
            }*/
        }

        if ($currentType == 'save') {
            $this->saveToDb($questionList);
            $this->redirect('');
            return;
        }
        
        return $this->render('nmkd/questionsThemes.html.twig', array(
            'questions' => $questions,
            'themes' => $themes,
            'nextType' => $nextType,
            'currentType' => Container::get('params')->ukrTypes[$currentType],
        ));
    }
    
    private function setTypesToStorage($types)
    {
        foreach ($types as $type) {
            foreach ($_POST as $key => $val) {
                if(substr_count($key, $type) > 0) {
                    $num = str_replace($type, '', $key);
                    $storageTypes[$type][] = $num;
                }
            }
        }
        $this->storage()->set('types',$storageTypes);
    }
    
    private function getValuesByKeys($keys = array(), $arr = array())
    {
        foreach ($keys as $key) {
            $result[] = $arr[$key];
        }
        
        return $result;
    }
    
    private function getQTArray($data, $type)
    {
        $types = $this->storage()->get('types');
        $type = $types[$type];
        $data=rtrim(trim($data),',');
        $dataArr = explode(',',$data);
        $str = '';
        foreach($dataArr as $key=>$val){
            $buffer = explode(':',$val);
            foreach($buffer as $inkey=>$inval){
                $str .= $inval.'|';
            }
        }
        $testArr = explode('|',rtrim(trim($str),'|'));
        $cnt = count($testArr);
        for($i = 0; $i < $cnt; $i += 2)
        {
            $qArr[]=$type[$testArr[$i]];
            $tArr[]=$testArr[$i+1];
        }
        $questionTheme = array_combine($qArr,$tArr);

        return $questionTheme;
    }

    private function getTMArray($data)
    {
        $questions = $this->storage()->get('questions');
        $data=rtrim(trim($data),',');
        $dataArr = explode(',',$data);
        $str = '';
        foreach($dataArr as $key=>$val){
            $buffer = explode(':',$val);
            foreach($buffer as $inkey=>$inval){
                $str .= $inval.'|';
            }
        }
        $testArr = explode('|',rtrim(trim($str),'|'));
        $cnt = count($testArr);

        for($i = 0; $i < $cnt; $i += 2)
        {
            $themesArr[] = $testArr[$i];
            $modulesArr[] = $testArr[$i+1];
        }
        $themesModules = array_combine($themesArr,$modulesArr);

        return $themesModules;
    }

    private function saveToDb($questionList)
    {
        $model = $this->getModel('nmkd');
        $model->setAllQuestions($questionList);
        Container::get('static_storage')->unsetAll();
    }

    public function saveSessionAction($requestParams)
    {
        $model = $this->getModel('nmkd');
        $step = str_replace('_','-',$requestParams[0]);
        
        $model->saveSession($step, 1);
        Container::get('static_storage')->unsetAll();
        
        return $this->redirect('');
    }

    public function restoreSessionAction($requestParams)
    {
        $idDiscipline = $requestParams[0];

        $model = $this->getModel('nmkd');
        $sessionData = $model->getSession($idDiscipline);

        $this->storage()->setAll($sessionData);
        
        return $this->redirect($sessionData['step']);
    }

    public function editNmkdAction($params)
    {
        if (!isset($params[0])) {
            $templates = array(
                '/pdfTemplates/start.html.twig',
            );
        }
        if (isset($params[0]) && $params[0]=='np') {
            $templates = array(
                '/pdfTemplates/np/np1.html.twig',
                '/pdfTemplates/np/np2.html.twig',
                '/pdfTemplates/np/np3.html.twig',
                '/pdfTemplates/np/np4.html.twig',
                '/pdfTemplates/np/np5.html.twig',
                '/pdfTemplates/np/np6.html.twig',
                '/pdfTemplates/np/np7.html.twig',
                '/pdfTemplates/np/np8.html.twig',
                '/pdfTemplates/np/np9.html.twig',
            );
        }

        if (isset($params[0]) && $params[0]=='rp') {
            $templates = array(
                '/pdfTemplates/rp/rp1.html.twig',
                '/pdfTemplates/rp/rp2.html.twig',
                '/pdfTemplates/rp/rp3.html.twig',
                '/pdfTemplates/rp/rp4.html.twig',
                '/pdfTemplates/rp/rp5.html.twig',
                '/pdfTemplates/rp/rp6.html.twig',
                '/pdfTemplates/rp/rp7.html.twig',
                '/pdfTemplates/rp/rp8.html.twig',
                '/pdfTemplates/rp/rp12.html.twig',
            );
        }

        if (isset($params[0]) && $params[0]=='doc') {
            $templates = array(
                '/pdfTemplates/doc/dodatok1.html.twig',
                '/pdfTemplates/doc/dodatok2.html.twig',
                '/pdfTemplates/doc/dodatok3_1.html.twig',
                '/pdfTemplates/doc/dodatok3_2.html.twig',
                '/pdfTemplates/doc/dodatok3_3.html.twig',
                '/pdfTemplates/doc/dodatok3_4.html.twig',
                '/pdfTemplates/doc/dodatok3_5.html.twig',
                '/pdfTemplates/doc/dodatok3_6.html.twig',
                '/pdfTemplates/doc/dodatok4_1.html.twig',
                '/pdfTemplates/doc/dodatok4_2.html.twig',
                '/pdfTemplates/doc/dodatok4_3.html.twig',
                '/pdfTemplates/doc/dodatok4_4.html.twig',
                '/pdfTemplates/doc/dodatok4_5.html.twig',
                '/pdfTemplates/doc/dodatok4_6.html.twig',
                '/pdfTemplates/doc/dodatok4_7.html.twig',
                '/pdfTemplates/doc/dodatok4_8.html.twig',
                '/pdfTemplates/doc/dodatok5.html.twig',
            );
        }
        
        $this->render('nmkd/edit.html.twig',array(
                'nmkd' => $this->getModel('nmkdPdf')->getNmkdPdfData(1),
                'templates' => $templates,
        ));
    }

    public function downloadPdfAction()
    {
        $pdf = Container::get('pdf');                                   //get pdf object
                                                                        //adding templates to out
        
        $pdf->addPdfTemplate('pdfTemplates/test/np1.html.twig');
        $pdf->addPdfTemplate('pdfTemplates/test/np2.html.twig');
        $pdf->addPdfTemplate('pdfTemplates/test/np3.html.twig');
        $pdf->addPdfTemplate('pdfTemplates/test/np4.html.twig');
        $pdf->addPdfTemplate('pdfTemplates/test/np5.html.twig');

        $this->getModel('nmkdPdf');

                                                                        //downloading pdf
        $pdf->downloadPdf(array(
                'nmkd' => $this->getModel('nmkdPdf')->getNmkdPdfData(1),
        ));
    }

    public function downloadPdfFromStrAction()
    {
        $pdf = Container::get('pdf');
        $pdf->addPdfContent($_POST['content']);
        $pdf->downloadPdf(array(),'str');

        return;
    }


//---------------------------------------------------
    public function uploadQuestionsAction()
    {
        if (isset($_FILES['file']) && isset($_FILES['file']['tmp_name'])
                && $_FILES['file']['tmp_name'] != '') {

            $str = file_get_contents($_FILES['file']['tmp_name']);
            echo $str;
        }
        
    }

//--------------------------------------------------------

        
    
}
