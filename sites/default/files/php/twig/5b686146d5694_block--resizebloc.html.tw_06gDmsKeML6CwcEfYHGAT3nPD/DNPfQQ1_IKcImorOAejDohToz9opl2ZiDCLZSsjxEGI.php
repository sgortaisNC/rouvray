<?php

/* themes/site/templates/blocks/block--resizebloc.html.twig */
class __TwigTemplate_24f43b200d68c37b6bd3b14b98431ab5ec8fe12697add889b90ce74427ac4c7a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $tags = array("if" => 30, "block" => 32);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('if', 'block'),
                array(),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 30
        if ((($context["isEmpty"] ?? null) != true)) {
            // line 31
            echo "    <div class=\"changeSize text-info\">
        ";
            // line 32
            $this->displayBlock('content', $context, $blocks);
            // line 35
            echo "    </div>
";
        }
    }

    // line 32
    public function block_content($context, array $blocks = array())
    {
        // line 33
        echo "            ";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["content"] ?? null), "html", null, true));
        echo "
        ";
    }

    public function getTemplateName()
    {
        return "themes/site/templates/blocks/block--resizebloc.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  60 => 33,  57 => 32,  51 => 35,  49 => 32,  46 => 31,  44 => 30,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/site/templates/blocks/block--resizebloc.html.twig", "C:\\wamp\\www\\rouvray\\web\\themes\\site\\templates\\blocks\\block--resizebloc.html.twig");
    }
}
