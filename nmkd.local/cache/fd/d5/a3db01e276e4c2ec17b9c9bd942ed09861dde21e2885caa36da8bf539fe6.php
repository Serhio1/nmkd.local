<?php

/* /css/main.css */
class __TwigTemplate_fdd5a3db01e276e4c2ec17b9c9bd942ed09861dde21e2885caa36da8bf539fe6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "html,body {
    height:100%;
}

.offset {
    height:40px
}

ul.unmarked {
    margin-left: 0;
    padding-left: 0;
}
    ul.unmarked li {
        list-style-type: none;
    }

li.unmarked {
    list-style-type: none;
}

#q_input {
    width: 100%;
    min-height: 400px;
    height: auto;
    resize: none;
}

#inputForm {
    border: 1px solid #eee;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 30px;
}

.module {
    /*background-color: #ff0000;*/
    /*border: 1px solid #f00;*/
}

.theme {
    /*background-color: #00ff00;*/
    /*border: 1px solid #0f0;*/
}

.question {
    /*border: 1px solid #ccc;*/
}

#hierarchyList .module {
    
}

#hierarchyList .theme {

}

#hierarchyList li {
    margin-left: 60px;
    border: 1px solid #ccc;
}

.wrapper {}

.tools {
    /*display: table-cell;*/
    width: auto;
    position: fixed;
    top: 90px;
    left: 100%;
}
    .tools ul {
        margin-left: -40px;
        border: 1px solid #000;
        -webkit-border-top-left-radius: 5px;
        -webkit-border-bottom-left-radius: 5px;
        -moz-border-radius-topleft: 5px;
        -moz-border-radius-bottomleft: 5px;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        background-color:#F5F5F5;
    }
        .tools li {
            margin: 3px 5px;
            padding: 2px;
        }
#hierarchySearch {
    position: fixed;
    display: none;
    width: 98px;
    height: 25px;
    text-align: center left;
}

.search-shadow {
    -webkit-box-shadow: 0px 0px 12px 0px rgba(80, 189, 252, 0.75);
    -moz-box-shadow:    0px 0px 12px 0px rgba(80, 189, 252, 0.75);
    box-shadow:         0px 0px 12px 0px rgba(80, 189, 252, 0.75);
}

.column {
    /*display: table-cell;*/
    padding-bottom: 25px;
    width: 95%;
  }
.portlet {
    margin: 0 1em 1em 0;
    padding: 0;
}
.portlet-header {
    padding: 0.2em 0.3em;
    margin-bottom: 0.5em;
    position: relative;
    background-color: #fff;
    box-shadow: inset 250px 0 100px -10px rgba(183, 183, 183,.5);
}
.portlet-toggle {
    position: absolute;
    top: 50%;
    right: 0;
    margin-right: 2px;
}
    .ui-icon-plusthick {
        width: 20px;
        height: 20px;
        margin-top: -10px;
        background: url(\"/src/views/img/toggle-expand2.png\");
        background-repeat: no-repeat;
    }
    .ui-icon-minusthick {
        width: 20px;
        height: 20px;
        margin-top: -10px;
        background: url(\"/src/views/img/toggle-collapse2.png\");
        background-repeat: no-repeat;
    }
.portlet-content {
    padding: 0.4em;
}
.portlet-content:hover {
    cursor: pointer;
}
.portlet-placeholder {
    background-color: #eee;
    border: 1px dotted black;
    margin: 0 1em 1em 0;
    height: 50px;
}
  

.set-modules-table-top tr th,
.set-themes-table-top tr th {
    text-align: center
}


.set_themes_table {
    width: 100%;
}
    .set_themes_table tr td {
        cursor: default;
    }
    
    .set_themes_table thead tr td {
        text-align: center;
    }

    .set-modules-table tr td.check_theme,
    .set_themes_table tr td.check_theme {
        cursor: pointer;
    }

    .set_themes_table tr th {
        cursor: pointer;
        background-color: #F0F0F0;
    }

    .set-modules-table tr:hover,
    .set_themes_table tbody tr:hover,
    .set-types-table tr:hover {
        background-color: #F0F0F0;
    }

    .submit_btn {
        margin: 5px auto;
        width: 250px;
    }

.set-types-table-top thead th{
    white-space: nowrap;
    overflow: hidden;
}
    .set-types-table thead {
        background-color: #F0F0F0;
    }
    .set-types-table td.check_type:hover {
        cursor: pointer;
    }

    .set-types-table .module {
         text-align:center;
         box-shadow:inset 50px 0 15px -10px rgba(253,225,106,.5);
    }

    .set-types-table .theme {
         text-align:center;
         box-shadow:inset 30px 0 15px -10px rgba(148,213,71,.5);
    }
    


.fixedColumn .fixedTable td {
    padding: 8px;
    border: 1px solid #fff;
}

.fixedTable tr td {
    #width: auto;
}

#questions_to_themes {
    width: 100%;
}

    #questions_to_themes thead tr th {
        text-align: center;
    }

    #questions_to_themes tbody tr td:hover {
        cursor: pointer;
    }

    #sortable1,
    #sortable2 {
        padding: 0;
        margin-left: 0;
    }
    

        #sortable1 li,
        #sortable2 li {
            padding: 8px;
            margin: 1px;
            list-style-type: none;
        }

        #sortable1 li.question {
            background-color: #D8D8D8;
        }

        #sortable2 li ol li.question {
            margin-left: 35px;
            
            background-color: #DFF0D8;
        }

        #sortable2 li.theme {
            background-color: #eaeaea;
        }

        #sortable2 ol.questions-container {
            padding:2px;
            background-color: #ddd;
        }

.hidden {
    display: none;
}


/*---------------------------------------------------*/
#wrap
{
min-height: 100%; 
}



footer 
{
margin-top: -70px;
height: 70px;
clear:both;
color:#000;
background-color: #eee
} 

/*----------------------------------------------------*/

@font-face {
  font-family: 'Glyphicons Halflings';
  src: url('/src/views/fonts/glyphicons-halflings-regular.eot');
  src: url('/src/views/fonts/glyphicons-halflings-regular.eot') format('embedded-opentype'), url('/src/views/fonts/glyphicons-halflings-regular.woff') format('woff'), url('/src/views/fonts/glyphicons-halflings-regular.ttf') format('truetype'), url('/src/views/fonts/glyphicons-halflings-regular.svg') format('svg');
}

.nmkd-hint {
    margin-bottom: 20px;
}
    .nmkd-hint p {
        padding: 10px;
    }

.nmkd-controls {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 5px 8px;
}
    .nmkd-next-btn {
        float:right;
    }

/*------------------------------------------------------*/
body.dragging, body.dragging * {
  cursor: move !important;
}

.dragged {
  position: absolute;
  opacity: 0.5;
  z-index: 2000;
}


.register-form {
    border: 1px solid #eee;
    border-radius: 5px;
    padding: 10px;
    max-width: 750px;
}

#q_input {
    max-width: 100%;
}

#input_form {
    border: 1px solid #eee;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
}

.input-menu span{
    float: right;
    margin: 1px 0px 3px 3px;
}

.search-input {
    width: 200px;
    display: inline-block;
}
.search-hide {
    display: none;
}


#hidechecked th.headerSortUp,
#hidechecked th.header,
#hidechecked th.headerSortDown {
    text-align: center;
    font-weight: normal;
}
    #hidechecked th.header span {
        background-image: url(\"http://www.npp-photon.ru/images/sort_icon.gif\");
        background-repeat: no-repeat;
        background-position: center;
    }

    #hidechecked th.headerSortUp span {
        background-image: url(\"http://www.nerjamarrentals.com/images/icon_up_sort_arrow.png\");
        background-repeat: no-repeat;
        background-position: center;
    }

    #hidechecked th.headerSortDown span {
        background-image: url(\"http://www.nerjamarrentals.com/images/icon_down_sort_arrow.png\");
        background-repeat: no-repeat;
        background-position: center;
    }

#menu .submenu {
    padding-left: 50px;
}
#menu li.active {
    color: #fff;
}
#menu li:hover {
    background-color: #eee;
    cursor: pointer;
}



.reset-this {
    animation : none;
    animation-delay : 0;
    animation-direction : normal;
    animation-duration : 0;
    animation-fill-mode : none;
    animation-iteration-count : 1;
    animation-name : none;
    animation-play-state : running;
    animation-timing-function : ease;
    backface-visibility : visible;
    background : 0;
    background-attachment : scroll;
    background-clip : border-box;
    background-color : transparent;
    background-image : none;
    background-origin : padding-box;
    background-position : 0 0;
    background-position-x : 0;
    background-position-y : 0;
    background-repeat : repeat;
    background-size : auto auto;
    border : 0;
    border-style : none;
    border-width : medium;
    border-color : inherit;
    border-bottom : 0;
    border-bottom-color : inherit;
    border-bottom-left-radius : 0;
    border-bottom-right-radius : 0;
    border-bottom-style : none;
    border-bottom-width : medium;
    border-collapse : separate;
    border-image : none;
    border-left : 0;
    border-left-color : inherit;
    border-left-style : none;
    border-left-width : medium;
    border-radius : 0;
    border-right : 0;
    border-right-color : inherit;
    border-right-style : none;
    border-right-width : medium;
    border-spacing : 0;
    border-top : 0;
    border-top-color : inherit;
    border-top-left-radius : 0;
    border-top-right-radius : 0;
    border-top-style : none;
    border-top-width : medium;
    bottom : auto;
    box-shadow : none;
    box-sizing : content-box;
    caption-side : top;
    clear : none;
    clip : auto;
    color : inherit;
    columns : auto;
    column-count : auto;
    column-fill : balance;
    column-gap : normal;
    column-rule : medium none currentColor;
    column-rule-color : currentColor;
    column-rule-style : none;
    column-rule-width : none;
    column-span : 1;
    column-width : auto;
    content : normal;
    counter-increment : none;
    counter-reset : none;
    cursor : auto;
    direction : ltr;
    display : inline;
    empty-cells : show;
    float : none;
    font : normal;
    font-family : inherit;
    font-size : medium;
    font-style : normal;
    font-variant : normal;
    font-weight : normal;
    height : auto;
    hyphens : none;
    left : auto;
    letter-spacing : normal;
    line-height : normal;
    list-style : none;
    list-style-image : none;
    list-style-position : outside;
    list-style-type : disc;
    margin : 0;
    margin-bottom : 0;
    margin-left : 0;
    margin-right : 0;
    margin-top : 0;
    max-height : none;
    max-width : none;
    min-height : 0;
    min-width : 0;
    opacity : 1;
    orphans : 0;
    outline : 0;
    outline-color : invert;
    outline-style : none;
    outline-width : medium;
    overflow : visible;
    overflow-x : visible;
    overflow-y : visible;
    padding : 0;
    padding-bottom : 0;
    padding-left : 0;
    padding-right : 0;
    padding-top : 0;
    page-break-after : auto;
    page-break-before : auto;
    page-break-inside : auto;
    perspective : none;
    perspective-origin : 50% 50%;
    position : static;
    /* May need to alter quotes for different locales (e.g fr) */
    quotes : '\\201C' '\\201D' '\\2018' '\\2019';
    right : auto;
    tab-size : 8;
    table-layout : auto;
    text-align : inherit;
    text-align-last : auto;
    text-decoration : none;
    text-decoration-color : inherit;
    text-decoration-line : none;
    text-decoration-style : solid;
    text-indent : 0;
    text-shadow : none;
    text-transform : none;
    top : auto;
    transform : none;
    transform-style : flat;
    transition : none;
    transition-delay : 0s;
    transition-duration : 0s;
    transition-property : none;
    transition-timing-function : ease;
    unicode-bidi : normal;
    vertical-align : baseline;
    visibility : visible;
    white-space : normal;
    widows : 0;
    width : auto;
    word-spacing : normal;
    z-index : auto;
}

";
    }

    public function getTemplateName()
    {
        return "/css/main.css";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,  143 => 70,  140 => 69,  136 => 60,  133 => 59,  129 => 55,  126 => 54,  111 => 72,  109 => 69,  99 => 61,  97 => 59,  92 => 56,  47 => 13,  44 => 12,  38 => 10,  35 => 9,  32 => 8,  30 => 7,  22 => 1,  105 => 40,  94 => 38,  90 => 54,  72 => 21,  60 => 17,  52 => 14,  45 => 13,  41 => 11,  31 => 4,  28 => 3,);
    }
}
