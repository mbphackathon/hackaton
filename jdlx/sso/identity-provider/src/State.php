<?php
namespace Mybestpro\SSO\IdentityProvider;


/**
 *
 * This class is used to encapsulate "$state" array used by SimpleSAML into an object
 */

class State implements \ArrayAccess
{

    protected $data;


    public static function getCurrent()
    {

        if (isset($_REQUEST['AuthState'])) {
            $authStateId = $_REQUEST['AuthState'];
            $stateData = \SimpleSAML_Auth_State::loadState($authStateId, \sspmod_core_Auth_UserPassBase::STAGEID);
            $instance = new static($stateData);
            return $instance;
        } else {
            return false;
        }
    }

    public static function getById($id, $stage, $allowMissing = false)
    {
        $stateData = \SimpleSAML_Auth_State::loadState($id, $stage, $allowMissing);
        $instance = new static($stateData);
        return $instance;
    }




    public function __construct(array $state)
    {
        $this->data = $state;
    }


    public function getId($rawId = FALSE)
    {
        $state = $this->toArray();
        return \SimpleSAML_Auth_State::getStateId($state, $rawId);
    }

    public function save($stage, $rawId = false)
    {
        $data = $this->toArray();
        $id = \SimpleSAML_Auth_State::saveState($data, $stage, $rawId);

        $this->loadFromArray($data);

        return $id;
    }

    public function getRestartURL() {
        if(isset($this->data['SimpleSAML_Auth_State.restartURL'])) {
            return $this->data['SimpleSAML_Auth_State.restartURL'];
        }
        else {
            throw new \RuntimeException('No restart URL available. Current state seems to be corrupted');
        }
    }

    public function loadFromArray($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getServiceId()
    {
        if (isset($this->data['SPMetadata']) && isset($this->data['SPMetadata']['entityid'])) {
            return $this->data['SPMetadata']['entityid'];
        } else {
            return null;
        }
    }

    public function getQName()
    {
        if (isset($this->data['SPMetadata']) && isset($this->data['SPMetadata']['service-qname'])) {
            return $this->data['SPMetadata']['service-qname'];
        } else {
            return null;
        }
    }


    public function getTemplate()
    {
        if (isset($this->data['SPMetadata']) && isset($this->data['SPMetadata']['template'])) {
            return $this->data['SPMetadata']['template'];
        } else {
            return null;
        }
    }

    public function setUserAttributes($values) {
        $this->data['Attributes']=$values;
        return $this;
    }


    public function toArray()
    {
        return $this->data;
    }


    public function offsetExists($offset)
    {
        if (isset($this->data[$offset])) {
            return true;
        } else {
            return false;
        }
    }

    public function offsetGet($offset)
    {
        if (isset($this->data[$offset])) {
            return $this->data[$offset];
        } else {
            return null;
        }
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if (isset($this->data[$offset])) {
            unset($this->data[$offset]);
        }
    }


}
