<?php

function uzupelnij_int_zerami($i, $c)
{
    return str_pad($i, $c, '0', STR_PAD_LEFT);
}
