<?php

class Parameters
{
    public $dbHost = 'localhost';
    public $dbUser = 'postgres';
    public $dbPass = 'postgres';
    public $dbName = 'nmkd';
    public $dbChar = 'utf8';
    
    //public $vendor = '/ololo.net';  //for windows
    public $vendor = '';  //for linux
    
    public $types = array(
        'lection',
        'practical',
        'seminary',
        'laboratory',
        'individual',
        'self'
    );

    public $ukrTypes = array(
        'lection' => 'Лекційні питання',
        'practical' => 'Практичні питання',
        'seminary' => 'Семінарські питання',
        'laboratory' => 'Лабораторні питання',
        'individual' => 'Індивідуальні питання',
        'self'  => 'Питаня на самостійне опрацюваня',
    );
    
    
    public function getViewDir()
    {
        return $_SERVER['DOCUMENT_ROOT'].$this->vendor.'/src/views/';
    }
    
    public function getCacheDir()
    {
        return $_SERVER['DOCUMENT_ROOT'].$this->vendor.'/cache';
    }
//------------------------------------
    public function getPdfDir()
    {
        return $_SERVER['DOCUMENT_ROOT'].$this->vendor.'/src/views/pdfTemplates';
    }

    public function getMPdfLocation()
    {
        return $_SERVER['DOCUMENT_ROOT'].$this->vendor.'/lib/MPDF57/mpdf.php';
    }
//------------------------------------
    public function getNmkdPdfData()
    {
        return array(
            'year'                  => date('Y'),
            'order'                 => '545 — д',
            'orderDate'             => '19.08.2013',
            //'disc_name'               => 'Алгоритмізація і програмування',    //will added in model
            'knowledge_kind'        => 'Some kind of knowledge',    //will added in model
            'training_direction'    => 'Автоматика та управління',  //will added in model
            'specialization'        => 'Автоматизація та комп\'ютерно-інтегровані технології',  //will added in model
            'trainingForm'          => 'Some form of training', //will added in model
            'faculty'               => 'Some faculty',  //will added in model
            'cathedra'              => 'автоматизації та комп’ютерно-інтегрованих технологій',  //will added in model
            'redactor'              => 'Some redactor', //will added in model
            'reviewers'             => 'Some reviewers',    //will added in model
            'ed_qualification'      => 'Some qualification',    //will added in model
            'opp_code'              => '0000',  //will added in model
            'developer'             => 'Л.І. Гладка', //will added in model
            'ectsCredits'           => '12',
            'modules'               => '4',
            'contextModules'        => '4',
            'hours'                 => '432',
            'weekHours'             => '12',
            'qualificationLevel'    => 'бакалавр',
            'trainingYears'         => '1',
            'semesters'             => '1,2',
            'lectionHours'          => '32',
            'seminaryHours'         => '24',
            'laboratoryHours'       => '108',
            'selfHours'             => '136',
            'individualHours'       => '132',
            'controlTest'           => 'екзамен',
            'tpl_lection_themes'    => 'ТЕМИ ЛЕКЦІЙНИХ ЗАНЯТЬ',
            'tpl_practical_themes'  => 'ТЕМИ ПРАКТИЧНИХ ЗАНЯТЬ',
            'tpl_seminary_themes'   => 'ТЕМИ СЕМІНАРСЬКИХ ЗАНЯТЬ',
            'tpl_laboratory_themes' => 'ТЕМИ ЛАБОРАТОРНИХ ЗАНЯТЬ',
            'tpl_individual_themes' => 'ТЕМИ ІНДИВІДУАЛЬНИХ ЗАНЯТЬ',
            'tpl_self_themes'       => 'ТЕМИ САМОСТІЙНИХ ЗАНЯТЬ',
            'tpl_lection'           => 'Лекційне',
            'tpl_practical'         => 'Практичне',
            'tpl_seminary'          => 'Семінарське',
            'tpl_laboratory'        => 'Лабораторне',
            'tpl_individual'        => 'Індивідуальне',
            'tpl_self'              => 'Самостійне',
            
            
        );
    }

}
