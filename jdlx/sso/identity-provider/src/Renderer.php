<?php
namespace Mybestpro\SSO\IdentityProvider;



class Renderer
{

    protected $content;

    protected $state;

    public function __construct($content, $state)
    {

        $this->state = new State($state);


        $this->content = $content;
    }


    public function render()
    {
        $template = $this->state->getTemplate();
        if($template && isset($template['template'])) {
            if(is_file($template['template'])) {
                //$content is used in the template
                $content = $this->content;
                ob_start();
                include($template['template']);
                return ob_get_clean();
            }
        }
        return $this->content;
    }


}
