<?php

namespace pkmnfriends\Domain\Files\Files\Access;

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
        if (0 === strpos(basename($path), '.')) {
            return 0 === strpos(basename($path), '.')
                ? !($attr === 'read' || $attr === 'write')
                : null;
        }

        switch ($attr) {
            case 'locked':
            case 'read':
                return true;
            case 'write':
            case 'hidden':
            default:
                return false;
        }
    }
}
