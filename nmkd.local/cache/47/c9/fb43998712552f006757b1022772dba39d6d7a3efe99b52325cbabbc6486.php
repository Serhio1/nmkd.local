<?php

/* main/homepage.html.twig */
class __TwigTemplate_47c9fb43998712552f006757b1022772dba39d6d7a3efe99b52325cbabbc6486 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("base.html.twig");

        $this->blocks = array(
            'main' => array($this, 'block_main'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_main($context, array $blocks = array())
    {
        // line 4
        echo "


<div class=\"page-header\">
  <h1>Вітаємо в АІАС НМКД! <small>Для початку роботи оберіть дисципліну</small></h1>
</div>

<ul id=\"menu\" class=\"list-group\" style=\"list-style-type:none\">
";
        // line 12
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["disciplines"]) ? $context["disciplines"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 13
            echo "    <li id=\"item";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["row"]) ? $context["row"] : null), "id"), "html", null, true);
            echo "\" class=\"list-group-item\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["row"]) ? $context["row"] : null), "name"), "html", null, true);
            echo "</li>
    <a class=\"list-group-item submenu item";
            // line 14
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["row"]) ? $context["row"] : null), "id"), "html", null, true);
            echo "\" href=\"/nmkd/input/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["row"]) ? $context["row"] : null), "id"), "html", null, true);
            echo "\">
        <span class=\"glyphicon glyphicon-cog\"></span> &nbsp;&nbsp;&nbsp;&nbsp;Сформувати НМКД
    </a>
    <a class=\"list-group-item submenu item";
            // line 17
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["row"]) ? $context["row"] : null), "id"), "html", null, true);
            echo "\" href=\"/nmkd/edit/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["row"]) ? $context["row"] : null), "id"), "html", null, true);
            echo "\">
        <span class=\"glyphicon glyphicon-eye-open\"></span> &nbsp;&nbsp;&nbsp;&nbsp;Переглянути НМКД
    </a>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        echo "</ul>

<script>
\$(function(){\$('#menu .submenu').css('display','none');});
\$('#menu').on('click','li',function(){
    submenuClass = \$(this).attr('id');
    \$('.'+submenuClass).slideToggle(300);
    \$(this).toggleClass('active');
});
</script>


<!--<a href=\"/nmkd/download-pdf\">Download</a><br>-->



";
        // line 37
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["sessionList"]) ? $context["sessionList"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["sessionItem"]) {
            // line 38
            echo "    <!--<a href=\"restore-session/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["sessionItem"]) ? $context["sessionItem"] : null), "id_disc"), "html", null, true);
            echo "\">Відновити сессію НМКД \"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["sessionItem"]) ? $context["sessionItem"] : null), "name"), "html", null, true);
            echo "\"</a><br>-->
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sessionItem'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 40
        echo "

";
    }

    public function getTemplateName()
    {
        return "main/homepage.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 40,  94 => 38,  90 => 37,  72 => 21,  60 => 17,  52 => 14,  45 => 13,  41 => 12,  31 => 4,  28 => 3,);
    }
}
