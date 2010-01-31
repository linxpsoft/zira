<?php
/** Simian grid services
 *
 * PHP version 5
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR
 * IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
 * OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
 * NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
 * THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 *
 * @package    SimianGrid
 * @author     Jim Radford <http://www.jimradford.com/>
 * @copyright  Open Metaverse Foundation
 * @license    http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link       http://openmetaverse.googlecode.com/
 */
    require_once('Interface.OSD.php');
    class UUID implements IOSD
    {
        public $UUID;
        const Zero = '00000000-0000-0000-0000-000000000000';
        const strpat = '/^(?<UUID>[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12})$/';
        
        public function __construct($uuid = self::Zero)
        {
            $this->UUID = $uuid;
        }

        public function __toString()
        {
            return $this->UUID;
        }

        public function toOSD()
        {
            return sprintf('"%s"', $this->UUID);
        }

        static function fromOSD($osdStr)
        {
            if(preg_match(self::strpat, preg_replace('/[\s\"]?/', '', $osdStr), $matches))
            {
                return new UUID($matches["UUID"]);
            }
            throw new Exception("The input string does not appear to be a valid UUID: " + $osdStr, 0);
        }

        static function Parse($str)
        {
            if(preg_match(self::strpat, preg_replace('/[\s\"]?/', '', trim($str)), $matches))
            {
                return new UUID($matches["UUID"]);
            } else {
                throw new Exception("The input string does not appear to be a valid UUID: " + $str, 0);
            }
        }

        static function TryParse($str, &$uuid)
        {
            if(preg_match(self::strpat, preg_replace('/[\s\"]?/', '', trim($str)), $matches))
            {
                $uuid = new UUID($matches["UUID"]);
                return TRUE;
            } else {
                return FALSE;
            }
        }

        static function Random()
        {
            return new UUID(sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                mt_rand( 0, 0x0fff ) | 0x4000,
                mt_rand( 0, 0x3fff ) | 0x8000,
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ) ));
        }    
    }
