<?php

namespace Notejam;

interface Exception
{

}



class InvalidArgumentException extends \InvalidArgumentException
{

}



class InvalidPasswordException extends InvalidArgumentException
{

}
