<?php

namespace template\Domain\Users\Users\Traits;

trait GenrableTrait
{

    /**
     * User gender
     *
     * @return bool
     */
    public function getGenderAttribute()
    {
        if (!in_array($this->civility, self::CIVILITIES)) {
            return self::GENDER_UNDEFINED;
        }

        return in_array($this->civility, self::GENDER_FEMALE_CIVILITIES)
            ? self::GENDER_FEMALE
            : self::GENDER_MALE;
    }
}
