<?php
namespace Mybestpro\SSO\IdentityProvider;


use Mybestpro\SSO\IdentityProvider\Bridge\SimpleSAML\AuthentificationFilter;
use Mybestpro\SSO\IdentityProvider\Filters\Test;



class FilterLoader extends AuthentificationFilter
{




    public function process(&$state)
    {


        $stateObject=new State($state);

        $test=new Test($stateObject);
        $test->apply();


        $state=$stateObject->toArray();



        /*
        $stateObject=new State($state);
        $state['Attributes']['identity.id'] = array($state['SPMetadata']['entity-caption'].'-'.uniqid());
        if($state['SPMetadata']['entity-caption']=='demo-wengo') {
            $state['Attributes']['identity.something'] = array("C'est clair !");
        }
        else {
            $state['Attributes']['identity.something'] = array("La loi c'est moi");
        }
        //*/

    }
}

