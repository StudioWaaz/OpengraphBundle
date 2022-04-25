<?php
namespace Waaz\OpengraphBundle\Structure;

use PHPCR\NodeInterface;
use Sulu\Component\Content\Extension\AbstractExtension;
use Sulu\Component\Content\Extension\ExportExtensionInterface;

class OpengraphStructureExtension extends AbstractExtension implements ExportExtensionInterface
{
    /**
    * name of structure extension.
    */
    const OPENGRAPH_EXTENSION_NAME = 'opengraph';

    protected $properties = [
        'og_title',
        'og_type',
        'og_description',
        'og_image',
    ];

    protected $name = self::OPENGRAPH_EXTENSION_NAME;

    protected $additionalPrefix = 'opengraph';

    public function save(NodeInterface $node, $data, $webspaceKey, $languageCode)
    {
        $this->setLanguageCode($languageCode, 'i18n', null);

        $data = $this->encodeImages($data);

        $this->saveProperty($node, $data, 'og_title');
        $this->saveProperty($node, $data, 'og_type');
        $this->saveProperty($node, $data, 'og_description');
        $this->saveProperty($node, $data, 'og_image');
    }

    public function load(NodeInterface $node, $webspaceKey, $languageCode)
    {
        $ogImageNode = $this->loadProperty($node, 'og_image');
        $ogImage = null;
        if ($ogImageNode) {
            $ogImage = json_decode($ogImageNode, true);
        }

        return [
            'og_title' => $this->loadProperty($node, 'og_title'),
            'og_type' => $this->loadProperty($node, 'og_type'),
            'og_description' => $this->loadProperty($node, 'og_description'),
            'og_image' => $ogImage,
        ];
    }

    public function export($properties, $format = null)
    {
        $data = [];
        foreach ($properties as $key => $property) {
            $value = $property;
            if (\is_bool($value)) {
                $value = (int) $value;
            }

            $data[$key] = [
                'name' => $key,
                'value' => $value,
                'type' => '',
            ];
        }

        return $data;
    }

    public function import(NodeInterface $node, $data, $webspaceKey, $languageCode, $format)
    {
        $this->setLanguageCode($languageCode, 'i18n', null);

        $this->save($node, $data, $webspaceKey, $languageCode);
    }

    public function getImportPropertyNames()
    {
        return $this->properties;
    }

    private function encodeImages(array $data)
    {
        if ($data['og_image']) {
            $data['og_image'] = json_encode($data['og_image']);
        }

        return $data;
    }
}