<?php

/* themes/site/templates/parts/footer.html.twig */
class __TwigTemplate_2848b45bff806258504ec5024107462daef5a6e44fe65907d92c2323f4e76828 extends Twig_Template
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
        echo "<footer class=\"mt-5 with_shadow\">

    <div class=\"bg-info\">
        <div class=\"container\">
            <div class=\"d-flex flex-wrap flex-column align-item-between h-100\">
                ";
        // line 6
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "footer", array()), "html", null, true));
        echo "
            </div>
        </div>
    </div>
    <div class=\"bg-warning py-2\">
        <div class=\"container\">
            <div class=\"row\">
                <div class=\"d-flex justify-content-between w-100\">
                ";
        // line 14
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "secondary_menu", array()), "html", null, true));
        echo "
                </div>
                <!--<div class=\"col-lg-5\">
                    <div class=\"d-flex\">
                        <ul class=\"p-0 m-0 inline_menu\">
                            <li class=\"d-inline\"><a href=\"#\">Espace presse</a></li>
                            <li class=\"d-inline\"><a href=\"#\">Marchés publics</a></li>
                            <li class=\"d-inline\"><a href=\"#\">Partenaires</a></li>
                        </ul>
                        <ul class=\"p-0 m-0 social_menu\">
                            <li class=\"d-inline\">
                                <a href=\"\"><i class=\"fab fa-facebook-f\"></i></a>
                            </li>
                            <li class=\"d-inline\">
                                <a href=\"\"><i class=\"fab fa-twitter\"></i></a>
                            </li>
                            <li class=\"d-inline\">
                                <a href=\"\"><i class=\"fab fa-linkedin-in\"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class=\"col-lg-7 text-lg-right rightmenu\">
                    <div class=\"d-flex flex-column flex-md-row text-primary\">

                        <ul class=\"p-0 m-0 inline_menu withLine\">
                            <li class=\"d-inline\"><a href=\"\">Plan du site</a></li>
                            <li class=\"d-inline\"><a href=\"\">Mentions légales</a></li>
                            <li class=\"d-inline\"><a href=\"\">CGU</a></li>
                            <li class=\"d-inline\"><a href=\"\">Crédits</a></li>
                            <li class=\"d-inline\"><a href=\"\">Contact webmaster</a></li>
                        </ul>
                        <div> réalisation : <a href=\"https://net-com.fr\" target=\"_blank\">Net.Com</a> - 2017</div>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</footer>";
    }

    public function getTemplateName()
    {
        return "themes/site/templates/parts/footer.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  61 => 14,  50 => 6,  43 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/site/templates/parts/footer.html.twig", "/home/var/www/vhosts/ch-lerouvray.fr/ch-rouvray.netcomdev2.com/web/themes/site/templates/parts/footer.html.twig");
    }
}
