<?php

/* themes/site/templates/blocks/block--homenousrejoindrebloc.html.twig */
class __TwigTemplate_0f1a73df141cd113b162a7f882fb2da564a3081951ae7151a4a429653db57251 extends Twig_Template
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
        $tags = array("if" => 30, "block" => 36);
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
            echo "    <div class=\"col-lg-7 nous-rejoindre\">
        <div class=\"shadow\">
            <h2 class=\"c-left text-info\">";
            // line 33
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["label"] ?? null), "html", null, true));
            echo "</h2>

            <div class=\"row\">
                ";
            // line 36
            $this->displayBlock('content', $context, $blocks);
            // line 39
            echo "            </div>
        </div>
    </div>
";
        }
    }

    // line 36
    public function block_content($context, array $blocks = array())
    {
        // line 37
        echo "                    ";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["content"] ?? null), "html", null, true));
        echo "
                ";
    }

    public function getTemplateName()
    {
        return "themes/site/templates/blocks/block--homenousrejoindrebloc.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  69 => 37,  66 => 36,  58 => 39,  56 => 36,  50 => 33,  46 => 31,  44 => 30,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/site/templates/blocks/block--homenousrejoindrebloc.html.twig", "/home/var/www/vhosts/ch-lerouvray.fr/ch-rouvray.netcomdev2.com/web/themes/site/templates/blocks/block--homenousrejoindrebloc.html.twig");
    }
}
