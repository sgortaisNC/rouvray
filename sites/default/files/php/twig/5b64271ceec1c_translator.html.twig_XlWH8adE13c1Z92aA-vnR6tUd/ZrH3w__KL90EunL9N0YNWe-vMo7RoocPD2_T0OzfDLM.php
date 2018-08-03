<?php

/* themes/site/templates/modules/nc_translator/translator.html.twig */
class __TwigTemplate_1f3155543b213f154084b7cc4749ade31c5f64118997e682381403010a53c0d8 extends Twig_Template
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
        $tags = array();
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array(),
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

        // line 1
        echo "<div class=\"dropdown mx-3\">
    <button class=\"btn dropdown-toggle\" type=\"button\" id=\"dropdownMenu1\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
        <img src=\"/themes/site/img/fr_flag.png\" alt=\"\">
    </button>
    <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu1\">
        <a class=\"dropdown-item\" href=\"#\"><img src=\"/themes/site/img/en_flag.jpg\" alt=\"\"></a>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "themes/site/templates/modules/nc_translator/translator.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/site/templates/modules/nc_translator/translator.html.twig", "C:\\wamp\\www\\rouvray\\web\\themes\\site\\templates\\modules\\nc_translator\\translator.html.twig");
    }
}
