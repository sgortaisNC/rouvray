<?php

/* themes/site/templates/pages/page--front.html.twig */
class __TwigTemplate_7dfc1d1e4061c9132a5bbbcd90e5255ad3cda450c478cebaf9543ab81cc43cb0 extends Twig_Template
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
        $tags = array("include" => 1);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('include'),
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
        $this->loadTemplate((($context["directory"] ?? null) . "/templates/parts/header.html.twig"), "themes/site/templates/pages/page--front.html.twig", 1)->display($context);
        // line 2
        echo "
<main>
    ";
        // line 4
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "top_content", array()), "html", null, true));
        echo "
    <div class=\"search_and_slide mb-5\">
        <div class=\"container\">
            <div class=\"row\">
                ";
        // line 8
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "home_top", array()), "html", null, true));
        echo "
            </div>
        </div>
    </div>
    <div class=\"py-2\"></div>
    ";
        // line 13
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "home", array()), "html", null, true));
        echo "

    <div class=\"container pt-5 mt-5\">
        ";
        // line 16
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "home_bis", array()), "html", null, true));
        echo "
    </div>
    <div class=\"bg-warning separator with_shadow shadow-bottom mb-5\"></div>
    <div class=\"container\">
        <div class=\"row\">
            ";
        // line 21
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "home_bottom", array()), "html", null, true));
        echo "
        </div>
    </div>
</main>
";
        // line 25
        $this->loadTemplate((($context["directory"] ?? null) . "/templates/parts/footer.html.twig"), "themes/site/templates/pages/page--front.html.twig", 25)->display($context);
    }

    public function getTemplateName()
    {
        return "themes/site/templates/pages/page--front.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  85 => 25,  78 => 21,  70 => 16,  64 => 13,  56 => 8,  49 => 4,  45 => 2,  43 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/site/templates/pages/page--front.html.twig", "C:\\wamp\\www\\rouvray\\web\\themes\\site\\templates\\pages\\page--front.html.twig");
    }
}
