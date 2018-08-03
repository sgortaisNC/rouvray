<?php

/* themes/site/templates/modules/nc_site/rejoindre.html.twig */
class __TwigTemplate_234d9efcbd48d91004d7ff00b8b5113c033ee8b187b3ed85ec7546e8f327452f extends Twig_Template
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
        $tags = array("if" => 19);
        $filters = array("raw" => 6);
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('if'),
                array('raw'),
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
        echo "<div class=\"col-md-7\">
    <div class=\"posr\">
        <img src=\"";
        // line 3
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["data"] ?? null), "formation", array()), "image", array()), "url", array()), "html", null, true));
        echo "\" alt=\"";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["data"] ?? null), "formation", array()), "image", array()), "alt", array()), "html", null, true));
        echo "\" class=\"img-fluid\">
        <div class=\"bg-white\">
            <h5 class=\"text-info\"><a href=\"";
        // line 5
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($this->getAttribute(($context["data"] ?? null), "formation", array()), "link", array()), "html", null, true));
        echo "\">";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($this->getAttribute(($context["data"] ?? null), "formation", array()), "title", array()), "html", null, true));
        echo "</a></h5>
            <p class=\"mb-0\">";
        // line 6
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute($this->getAttribute(($context["data"] ?? null), "formation", array()), "summary", array())));
        echo "</p>
        </div>
    </div>
</div>
<div class=\"col-md-5\">
    <div class=\"d-flex flex-column justify-content-between align-items-center text-center h-100\">
        <a href=\"";
        // line 12
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($this->getAttribute(($context["data"] ?? null), "formation", array()), "url", array()), "html", null, true));
        echo "\" class=\"text-left\">

            <span class=\"text-uppercase d-block\">SE FORMER à l'ifsi</span>
            <span>Découvrez toutes nos formations</span>
        </a>
        <a href=\"";
        // line 17
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($this->getAttribute(($context["data"] ?? null), "offre", array()), "url", array()), "html", null, true));
        echo "\">
            <span class=\"text-uppercase d-block\">Offres d'emploi</span>
            <span>Actuellement ";
        // line 19
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($this->getAttribute(($context["data"] ?? null), "offre", array()), "nb", array()), "html", null, true));
        echo " offre";
        if (($this->getAttribute($this->getAttribute(($context["data"] ?? null), "offre", array()), "nb", array()) > 1)) {
            echo "s";
        }
        echo " d'emploi</span>
        </a>
        <a href=\"";
        // line 21
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($this->getAttribute(($context["data"] ?? null), "candidature", array()), "url", array()), "html", null, true));
        echo "\">
            <i class=\"fas fa-plus-circle text-warning d-block\"></i>
            <span class=\"text-uppercase\">Déposez votre candidature</span>
        </a>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "themes/site/templates/modules/nc_site/rejoindre.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 21,  82 => 19,  77 => 17,  69 => 12,  60 => 6,  54 => 5,  47 => 3,  43 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/site/templates/modules/nc_site/rejoindre.html.twig", "/home/var/www/vhosts/ch-lerouvray.fr/ch-rouvray.netcomdev2.com/web/themes/site/templates/modules/nc_site/rejoindre.html.twig");
    }
}
