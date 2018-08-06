<?php

/* themes/site/templates/blocks/block--accesrapidebloc.html.twig */
class __TwigTemplate_1b4fbf2b529aaf8c77298ceaea9b8865d3ce998db907f8494b4fbf55ec510e73 extends Twig_Template
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
        $tags = array("if" => 30, "block" => 35);
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
            echo "    <div class=\"bg-info pt-1 pb-5 with_shadow mt-5\">
        <div class=\"container\">
            <h3 class=\"c-top my-5 text-center\">En un clic...</h3>
            <div class=\"d-flex flex-column align-items-center flex-md-row justify-content-center\">
                ";
            // line 35
            $this->displayBlock('content', $context, $blocks);
            // line 38
            echo "            </div>
        </div>
    </div>
";
        }
        // line 42
        echo "


";
    }

    // line 35
    public function block_content($context, array $blocks = array())
    {
        // line 36
        echo "                    ";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["content"] ?? null), "html", null, true));
        echo "
                ";
    }

    public function getTemplateName()
    {
        return "themes/site/templates/blocks/block--accesrapidebloc.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 36,  67 => 35,  60 => 42,  54 => 38,  52 => 35,  46 => 31,  44 => 30,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/site/templates/blocks/block--accesrapidebloc.html.twig", "C:\\wamp\\www\\rouvray\\web\\themes\\site\\templates\\blocks\\block--accesrapidebloc.html.twig");
    }
}
