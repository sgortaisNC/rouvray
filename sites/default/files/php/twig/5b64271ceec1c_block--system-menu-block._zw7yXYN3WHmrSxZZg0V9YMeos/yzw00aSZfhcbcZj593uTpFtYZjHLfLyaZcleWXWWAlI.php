<?php

/* themes/site/templates/block--system-menu-block.html.twig */
class __TwigTemplate_510715a6cc773f14b73c78e09634c4d619eb97fb6283c13a50b824d5f409196e extends Twig_Template
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
        $tags = array("if" => 36, "set" => 37, "block" => 48);
        $filters = array("clean_id" => 37, "without" => 38);
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('if', 'set', 'block'),
                array('clean_id', 'without'),
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

        // line 36
        if ((($context["isEmpty"] ?? null) != true)) {
            // line 37
            echo "    ";
            $context["heading_id"] = ($this->getAttribute(($context["attributes"] ?? null), "id", array()) . \Drupal\Component\Utility\Html::getId("-menu"));
            // line 38
            echo "    <nav role=\"navigation\" aria-labelledby=\"";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["heading_id"] ?? null), "html", null, true));
            echo "\"";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_without(($context["attributes"] ?? null), "role", "aria-labelledby"), "html", null, true));
            echo ">
        ";
            // line 40
            echo "        ";
            if ( !$this->getAttribute(($context["configuration"] ?? null), "label_display", array())) {
                // line 41
                echo "            ";
                $context["title_attributes"] = $this->getAttribute(($context["title_attributes"] ?? null), "addClass", array(0 => "visually-hidden"), "method");
                // line 42
                echo "        ";
            }
            // line 43
            echo "        ";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["title_prefix"] ?? null), "html", null, true));
            echo "
        <h2";
            // line 44
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["title_attributes"] ?? null), "setAttribute", array(0 => "id", 1 => ($context["heading_id"] ?? null)), "method"), "html", null, true));
            echo ">";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["configuration"] ?? null), "label", array()), "html", null, true));
            echo "</h2>
        ";
            // line 45
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["title_suffix"] ?? null), "html", null, true));
            echo "

        ";
            // line 48
            echo "        ";
            $this->displayBlock('content', $context, $blocks);
            // line 51
            echo "    </nav>
";
        }
    }

    // line 48
    public function block_content($context, array $blocks = array())
    {
        // line 49
        echo "            ";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["content"] ?? null), "html", null, true));
        echo "
        ";
    }

    public function getTemplateName()
    {
        return "themes/site/templates/block--system-menu-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  93 => 49,  90 => 48,  84 => 51,  81 => 48,  76 => 45,  70 => 44,  65 => 43,  62 => 42,  59 => 41,  56 => 40,  49 => 38,  46 => 37,  44 => 36,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/site/templates/block--system-menu-block.html.twig", "C:\\wamp\\www\\rouvray\\web\\themes\\site\\templates\\block--system-menu-block.html.twig");
    }
}
