<?php

/* themes/site/templates/modules/nc_site/multisites.html.twig */
class __TwigTemplate_33b021345a04ed0ea06c79c7b30999e4873b8096108176ae7a5767569d737cb6 extends Twig_Template
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
        $tags = array("set" => 1, "for" => 3, "if" => 4);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('set', 'for', 'if'),
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
        $context["cpt"] = 0;
        // line 2
        echo "<ol class=\"carousel-indicators\">
    ";
        // line 3
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["data"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["site"]) {
            // line 4
            echo "    <li data-target=\"#carouselFade\" data-slide-to=\"";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["cpt"] ?? null), "html", null, true));
            echo "\" class=\"";
            if ((($context["cpt"] ?? null) == 0)) {
                echo "active";
            }
            echo "\"></li>
    ";
            // line 5
            $context["cpt"] = (($context["cpt"] ?? null) + 1);
            // line 6
            echo "    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['site'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 7
        echo "</ol>
<h2 class=\"c-left text-info\">Consultez aussi...</h2>
<div class=\"carousel-inner\" role=\"listbox\">
    ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["data"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["site"]) {
            // line 11
            echo "        <div class=\"carousel-item ";
            if (($context["key"] == "multisite1")) {
                echo "active";
            }
            echo "\">
            <img class=\"d-block w-100 img-fluid\" src=\"";
            // line 12
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["site"], "image", array()), "html", null, true));
            echo "\" alt=\"";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["site"], "title", array()), "html", null, true));
            echo "\">
            <div class=\"carousel-caption d-flex align-items-center bg-white\">
                <a class=\"carousel-control-prev\" href=\"#carouselFade\" role=\"button\" data-slide=\"prev\">
                    <img src=\"/themes/site/img/arrow_left.png\" alt=\"\">
                </a>
                <a href=\"#\">
                    <img src=\"";
            // line 18
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["site"], "logo", array()), "html", null, true));
            echo "\" class=\"img-fluid mx-2\" alt=\"";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["site"], "title", array()), "html", null, true));
            echo "\">
                </a>
                <a href=\"#\">";
            // line 20
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["site"], "title", array()), "html", null, true));
            echo "</a>
                <a class=\"carousel-control-next\" href=\"#carouselFade\" role=\"button\" data-slide=\"next\">
                    <img src=\"/themes/site/img/arrow-right.png\" alt=\"\">
                </a>
            </div>
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['site'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "</div>";
    }

    public function getTemplateName()
    {
        return "themes/site/templates/modules/nc_site/multisites.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  116 => 27,  103 => 20,  96 => 18,  85 => 12,  78 => 11,  74 => 10,  69 => 7,  63 => 6,  61 => 5,  52 => 4,  48 => 3,  45 => 2,  43 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/site/templates/modules/nc_site/multisites.html.twig", "C:\\wamp\\www\\rouvray\\web\\themes\\site\\templates\\modules\\nc_site\\multisites.html.twig");
    }
}
