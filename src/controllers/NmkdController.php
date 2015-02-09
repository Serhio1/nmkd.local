<?php

class NmkdController extends Controller
{
    public function inputAction($params)
    {
        $model = $this->getModel('nmkd');
//@TODO: Remove this block
        //unset($_SESSION);

        //$model->clearDb();
//-------------------------------------------------------

        //$this->storage()->unsetAll();
        $idDiscipline = $params[0];
        $this->storage()->set('discipline',$params[0]);
        $questions = '';
        $this->hints[] = $this->params()->getHint('q_input');
        
        
        if ($this->storage()->isSetted('questions')) {
            $questions = $this->storage()->get('questions');
        } elseif ($model->sessionExists($idDiscipline)) {
            $this->storage()->setAll($model->getSession($idDiscipline));
            $questions = $this->storage()->get('questions');
        }
        
        
        if ($this->storage()->isSetted('hierarchy')) {
            $this->hints[] = $this->params()->getHint('modify_q_input');
        }
        
        if (isset($_POST['isAjax']) && isset($_POST['ajaxQuestions'])) {
            
            $questionStr = $_POST['ajaxQuestions'];
            $questionArr = explode('<br />', nl2br($questionStr));
            $questionArr = array_map('trim',$questionArr);
            $questionArr = array_filter($questionArr);
                    
            if ($this->storage()->isSetted('hierarchy')) {
                    $hierarchy = $this->storage()->get('hierarchy');           
// if questions were added
                foreach ($questionArr as $key => $question) {
                    if (!isset($questions[$key])) {
                        $hierarchy[$key] = 'question';
                    }
                }
                    
//if questions were removed
                foreach ($questions as $key=>$question) {
                    if (!isset($questionArr[$key])) {
                        unset($hierarchy[$key]);
                    }
                }
            }
            
            $this->storage()->set('questions', $questionArr);
            $this->storage()->set('hierarchy', $hierarchy);
        
            return;
        }
        if ($this->getForm('nmkdInputForm')) {
            if ($this->getFormData('nmkdInputForm')) {
                $this->saveSessionAction('1');

                $this->redirect(Router::buildUrl('/nmkd/set-hierarchy'));
            } else {
                $this->errors = $this->outErrors();
            }
        }

        return $this->render('nmkd/input.html.twig', array(
            'questions' => $questions,
            'hints' => $this->hints,
        ));
    }

    public function setHierarchyAction()
    {
        $questions = $this->storage()->get('questions');
        $hierarchy = array();
        $this->hints[] = $this->params()->getHint('hierarchy');

        if ($this->storage()->isSetted('hierarchy')) {
            $hierarchy = $this->storage()->get('hierarchy');
        }
        
// auto update hierarchy
        if (isset($_POST['isAjax']) && isset($_POST['hierarchy'])) {
            $this->storage()->set('hierarchy', (array)json_decode($_POST['hierarchy']));
            return;
        }
// redirect, when nextBtn pressed
        if ($this->getForm('questionsHierarchyForm')) {
            $this->redirect(Router::buildUrl('/nmkd/set-types'));
            return;
        }

        return $this->render('nmkd/setHierarchy.html.twig', array(
            'questions' => $questions,
            'hierarchy' => $hierarchy,
            'hints'=>$this->hints,
            'discipline' => $this->storage()->get('discipline'),
        ));
    }

    public function setTypesAction()
    {
        $questions = $this->storage()->get('questions');
        $hierarchy = $this->storage()->get('hierarchy');
        $this->hints[] = $this->params()->getHint('types');
        
        if ($this->storage()->isSetted('typesQuestions')) {
            $typesQuestions = $this->storage()->get('typesQuestions');
        } else {
            $typesQuestions = array();
        }
        
        if (isset($_POST['isAjax']) && isset($_POST['ajaxTypes'])) {
            $ajaxTypes = explode('&', $_POST['ajaxTypes']);
            //$ajaxTypes = json_decode($_POST['ajaxTypes']);
            $types = $this->params()->types;
            foreach ($types as $type) {
                foreach ($ajaxTypes as $field=>$val) {
                    $val = substr($val, 0, -3);
                    if (substr_count($val, $type)) {
                        $typesQuestions[explode('_',$val)[1]][explode('_',$val)[0]] = 1;
                        $this->storage()->set('typesQuestions',$typesQuestions);
                    }
                }
            }
            return;
        }

        if ($this->getForm('typesForm')) {
            if ($this->storage()->isSetted('typesQuestions')) {
                $this->getModel('nmkd')->setAll();
                $this->redirect(Router::buildUrl(''));
            }
           /*else {
                //$this->addError('no_type_selected');
                $this->errors = $this->outErrors();
            }*/
        }

        return $this->render('nmkd/setTypes.html.twig', array(
            'questions' => $questions,
            'hierarchy' => $hierarchy,
            'types_questions' => $typesQuestions,
            'hints'=>$this->hints,
        ));
    }

    public function saveSessionAction($requestParams)
    {
        $model = $this->getModel('nmkd');
        $step = str_replace('_','-',$requestParams[0]);

        $model->saveSession($step, 1);
        //Container::get('session_storage')->unsetAll();

        //return $this->redirect('');
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
        if (!empty($params[0])) {
            $disciplineId = $params[0];
        }

        if (!isset($params[1])) {
            $templates = array(
                '/pdfTemplates/start.html.twig',
            );
        }
        if (isset($params[1]) && $params[1]=='np') {
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

        if (isset($params[1]) && $params[1]=='rp') {
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

        if (isset($params[1]) && $params[1]=='doc') {
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
                'discipline_id' => $disciplineId,
                'nmkd' => $this->getModel('nmkdPdf')->getNmkdPdfData($disciplineId),
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

    public function createLabAction()
    {
        return $this->render('nmkd/createLab.html.twig', array(
            'hints' => $this->hints,
        ));
    }

}
