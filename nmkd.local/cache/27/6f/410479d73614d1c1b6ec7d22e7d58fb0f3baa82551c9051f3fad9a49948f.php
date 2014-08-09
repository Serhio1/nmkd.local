<?php

/* base.html.twig */
class __TwigTemplate_276f410479d73614d1c1b6ec7d22e7d58fb0f3baa82551c9051f3fad9a49948f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'main' => array($this, 'block_main'),
            'pdfRender' => array($this, 'block_pdfRender'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!doctype html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>НМКД</title>
    <style>
        ";
        // line 7
        $this->env->loadTemplate("/css/bootstrap.min.css")->display($context);
        // line 8
        echo "        ";
        $this->env->loadTemplate("/css/bootstrap-responsive.css")->display($context);
        // line 9
        echo "        ";
        $this->env->loadTemplate("/css/bootstrap-theme.min.css")->display($context);
        // line 10
        echo "        ";
        $this->env->loadTemplate("/css/bootstrap-theme.css.map")->display($context);
        // line 11
        echo "        ";
        $this->env->loadTemplate("/css/bootstrap.css.map")->display($context);
        // line 12
        echo "        ";
        $this->env->loadTemplate("/css/main.css")->display($context);
        // line 13
        echo "    </style>
    <script src=\"/src/views/js/jquery-1.9.1.js\"></script>
    <script src=\"/src/views/js/disableSelection.js\"></script>
    <script src=\"/src/views/js/bootstrap.min.js\"></script>
    <script src=\"/src/views/js/ajaxupload-v1.2.js\"></script>
</head>
<body>

<div id=\"wrap\">

<nav class=\"navbar navbar-inverse navbar-static-top\" role=\"navigation\">
  <div class=\"container-fluid\">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class=\"navbar-header\">
      <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\">
        <span class=\"sr-only\">Toggle navigation</span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
      </button>
      <a class=\"navbar-brand\" href=\"#\">НМКД</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">
      <ul class=\"nav navbar-nav\">
        <li><a href=\"/\">Головна</a></li>
      </ul>
      
      <ul class=\"nav navbar-nav navbar-right\">
        <li><a href=\"/user/login\"><span class=\"glyphicon glyphicon-lock\"></span>&nbsp;Увійти</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

    
<div id=\"main\" class=\"clear-top\" style=\"overflow-x:hidden;\">
<div class=\"row\"> 

    <main class=\"container\">
    ";
        // line 54
        $this->displayBlock('main', $context, $blocks);
        // line 56
        echo "    </main>

    <div style=\"width: 90%; padding: 20px; margin: 50px;\">
    ";
        // line 59
        $this->displayBlock('pdfRender', $context, $blocks);
        // line 61
        echo "    </div>

</div>
</div>
</div>

<footer id=\"footer\" class=\"navbar navbar-static-bottom navbar-default\" role=\"navigation\">
  <div class=\"container-fluid\">
\t";
        // line 69
        $this->displayBlock('footer', $context, $blocks);
        // line 72
        echo "  </div>
</footer>

    
    

    
    

</body>
</html>
";
    }

    // line 54
    public function block_main($context, array $blocks = array())
    {
        // line 55
        echo "    ";
    }

    // line 59
    public function block_pdfRender($context, array $blocks = array())
    {
        // line 60
        echo "    ";
    }

    // line 69
    public function block_footer($context, array $blocks = array())
    {
        // line 70
        echo "    <p class=\"navbar-text\">ЧНУ ім.Богдана Хмельницького, 2014р.</p>
    ";
    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  143 => 70,  140 => 69,  136 => 60,  133 => 59,  129 => 55,  126 => 54,  111 => 72,  109 => 69,  99 => 61,  97 => 59,  92 => 56,  47 => 13,  44 => 12,  38 => 10,  35 => 9,  32 => 8,  30 => 7,  22 => 1,  105 => 40,  94 => 38,  90 => 54,  72 => 21,  60 => 17,  52 => 14,  45 => 13,  41 => 11,  31 => 4,  28 => 3,);
    }
}
