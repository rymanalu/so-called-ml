<?php

namespace App;

/**
 * Codes for the representation of human sexes (ISO/IEC 5218).
 */
interface Sex
{
    const NOT_KNOWN = 0;
    const MALE = 1;
    const FEMALE = 2;
    const NOT_APPLICABLE = 9;
}
