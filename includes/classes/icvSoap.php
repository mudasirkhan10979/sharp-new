<?php
class ICVSoap extends SoapClient {

    public function __construct($wsdl, $options = null) {
        parent::__construct($wsdl, $options);
    }

    public function __doRequest($request, $location, $action, $version) { 
        $dom = new DOMDocument('1.0'); 
        // loads the SOAP request to the Document
        $dom->loadXML($request); 
        // Create a XPath object
        $path = new DOMXPath($dom); 
        // Search the nodes to fix
        $nodesToFix = $path->query('//SOAP-ENV:Envelope/SOAP-ENV:Body/*', null, true); 
        // Remove unwanted namespaces
        $this->fixNamespace($nodesToFix, 'ns1', 'http://tempuri.org/'); 
        // Save the modified SOAP request
        $request = $dom->saveXML(); 
        return parent::__doRequest($request, $location, $action, $version);
    } 
    public function fixNamespace(DOMNodeList $nodes, $namespace, $value) {
        // Remove namespace from envelope
        $nodes->item(0)
                ->ownerDocument
                ->firstChild
                ->removeAttributeNS($value, $namespace); 
        //iterate through the node list and remove namespace 
        foreach ($nodes as $node) { 
            $nodeName = str_replace($namespace . ':', '', $node->nodeName);
            $newNode = $node->ownerDocument->createElement($nodeName); 
            // Append namespace at the node level
            $newNode->setAttribute('xmlns', $value); 
            // And replace former node
            $node->parentNode->replaceChild($newNode, $node);
        }
    }
}