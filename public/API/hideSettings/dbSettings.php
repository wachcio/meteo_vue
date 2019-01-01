<?php
 
class dbSettings
{
    private $setting = [];

    public function getSettings()
    {
        $this->setSettings();
        return $this->setting;
    }

    private function setSettings()
    {
        $this->setting['dbName'] = "delphi_archiwum2";
        $this->setting['user'] = "delphi_archiwum2";
        $this->setting['password'] = "dx0663382";
        $this->setting['host'] = "wachcio.home.pl";
    }
}
