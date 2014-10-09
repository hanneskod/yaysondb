<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Exception;

/**
 * Exception when a document is unknown or malformed
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class InvalidDocumentException extends \RuntimeException implements \hanneskod\yaysondb\Exception
{
}
