<?php

/* modules/contrib/eu_cookie_compliance/templates/eu_cookie_compliance_popup_info.html.twig */
class __TwigTemplate_49d9a4648c521964e880f7569797bcf0707389969e583641a525bbc0c5622f2a extends Twig_Template
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
        $tags = array("if" => 33);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('if'),
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

        // line 28
        echo "
<div class=\"eu-cookie-compliance-banner eu-cookie-compliance-banner-info\">
  <div class =\"popup-content info eu-cookie-compliance-content\">
    <div id=\"popup-text\" class=\"eu-cookie-compliance-message\">
      ";
        // line 32
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["message"] ?? null), "html", null, true));
        echo "
      ";
        // line 33
        if (($context["disagree_button"] ?? null)) {
            // line 34
            echo "        <button type=\"button\" class=\"find-more-button eu-cookie-compliance-more-button\">";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["disagree_button"] ?? null), "html", null, true));
            echo "</button>
      ";
        }
        // line 36
        echo "    </div>
    <div id=\"popup-buttons\" class=\"eu-cookie-compliance-buttons\">
      <button type=\"button\" class=\"";
        // line 38
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["primary_button_class"] ?? null), "html", null, true));
        echo "\">";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["agree_button"] ?? null), "html", null, true));
        echo "</button>
      ";
        // line 39
        if (($context["secondary_button_label"] ?? null)) {
            // line 40
            echo "        <button type=\"button\" class=\"";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["secondary_button_class"] ?? null), "html", null, true));
            echo "\" >";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["secondary_button_label"] ?? null), "html", null, true));
            echo "</button>
      ";
        }
        // line 42
        echo "    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/contrib/eu_cookie_compliance/templates/eu_cookie_compliance_popup_info.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  81 => 42,  73 => 40,  71 => 39,  65 => 38,  61 => 36,  55 => 34,  53 => 33,  49 => 32,  43 => 28,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "modules/contrib/eu_cookie_compliance/templates/eu_cookie_compliance_popup_info.html.twig", "C:\\wamp\\www\\rouvray\\web\\modules\\contrib\\eu_cookie_compliance\\templates\\eu_cookie_compliance_popup_info.html.twig");
    }
}
