<?php

namespace App\DependencyInjection\Compiler;

// src/DependencyInjection/Compiler/MailTransportPass.php
namespace App\DependencyInjection\Compiler;

//use App\Mail\TransportChain;

use App\Document\DocumentType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ValidatorConfigPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // always first check if the primary service is defined
        //if (!$container->has(TransportChain::class)) {
        //    return;
        //}
        // $container->getParameterBag()->resolve();

        //$definition = $container->findDefinition(TransportChain::class);

        // find all service IDs with the app.mail_transport tag
        //$taggedServices = $container->findTaggedServiceIds('app.mail_transport');

        // foreach ($taggedServices as $id => $tags) {
        //     // add the transport service to the TransportChain service
        //     $definition->addMethodCall('addTransport', [new Reference($id)]);
        // }

        // $taggedServices = $container->findTaggedServiceIds('document.validator.config');

        // foreach ($taggedServices as $id => $tags) {
        //     $config = str_replace('.config', '', $id);
        //     $params = $container->getParameter($config);

        //     if (isset($params['document_types'])) {
        //         $types = $params['document_types'];

        //         $documentTypes = array_map(function ($type) {
        //             return new DocumentType(
        //                 $type['type'],
        //                 $type['from']  ?? null,
        //                 $type['till']  ?? null
        //             );
        //         }, $types);

        //         $definition = $container->findDefinition($id);
        //         $definition->addMethodCall('setDocumentTypes', [
        //             $documentTypes
        //         ]);
        //     }
        // }
    }
}
