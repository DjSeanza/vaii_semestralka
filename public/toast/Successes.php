<?php

namespace public\toast;

enum Successes: int
{
    case REGISTRATION = 1;
    case CONTENT_ADDED = 2;
    case CONTENT_DELETED = 3;
    case USER_DELETED = 4;
}