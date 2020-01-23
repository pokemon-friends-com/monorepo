<?php

namespace template\Domain\Files\Files\Access;

class ReadOnly
{

    /**
     * @param $attr
     * @param $path
     * @param $data
     * @param $volume
     *
     * @return bool|null
     */
    public static function checkAccess($attr, $path, $data, $volume)
    {
        $allowed = false;

        if (0 === strpos(basename($path), '.')) {
            return 0 === strpos(basename($path), '.')
                ? !($attr === 'read' || $attr === 'write')
                : null;
        }

        switch ($attr) {
            case 'locked':
            case 'read':
                $allowed = true;
                break;
            case 'write':
            case 'hidden':
            default:
                $allowed = false;
                break;
        }

        return $allowed;
    }
}
