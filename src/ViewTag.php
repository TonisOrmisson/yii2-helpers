<?php
namespace andmemasin\helpers;

use yii\helpers\Html;

/**
 * Class ViewTag
 * Generates an invisible HTML Tag that is meant for identifying page machine-readable (eg automated tests)
 * @package andmemasin\helpers
 * @author Tõnis Ormisson <tonis@andmemasin.eu>
 */
class ViewTag
{
    /** @var string $name */
    private $name;
    const PREFIX = "action";
    const DELIMITER = "::";

    /**
     * ViewTag constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return self::PREFIX . self::DELIMITER . Html::encode($this->name);
    }

    public function __toString()
    {
        return Html::tag("x-test", null, ['id' => $this->getId()]);
    }


}