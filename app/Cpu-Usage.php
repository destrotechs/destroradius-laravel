<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cpu-Usage extends Model
{
    private function getFilePath ($ fileName, $ content)
 {
  $ path = dirname (FILE). "\\ $ fileName";
  if (! file_exists ($ path)) {
   file_put_contents ($ path, $ content);
  }
  return $ path;
 }
 / **
  * Get CPU usage vbs file generation function
  * @return string return vbs file path
  * /
 private function getCupUsageVbsPath ()
 {
  return $ this-> getFilePath (
   'cpu_usage.vbs',
   "On Error Resume Next
    Set objProc = GetObject (\ "winmgmts: \\\\. \\ root \ cimv2: win32_processor = 'cpu0' \")
    WScript.Echo (objProc.LoadPercentage) "
  );
 }
 / **
  * Obtain total memory and available physical memory JSON vbs file generation function
  * @return string return vbs file path
  * /
 private function getMemoryUsageVbsPath ()
 {
  return $ this-> getFilePath (
   'memory_usage.vbs',
   "On Error Resume Next
    Set objWMI = GetObject (\ "winmgmts: \\\\. \\ root \ cimv2 \")
    Set colOS = objWMI.InstancesOf (\ "Win32_OperatingSystem \")
    For Each objOS in colOS
     Wscript.Echo (\ "{\" \ "TotalVisibleMemorySize \" \ ": \" & objOS.TotalVisibleMemorySize & \ ", \" \ "FreePhysicalMemory \" \ ": \" & objOS.FreePhysicalMemory & \ "} \")
    Next "
  );
 }
 / **
  * Get CPU usage
  * @return Number
  * /
 public function getCpuUsage ()
 {
  $ path = $ this-> getCupUsageVbsPath ();
  exec ("cscript -nologo $ path", $ usage);
  return $ usage [0];
 }
 / **
  * Get memory usage array
  * @return array
  * /
 public function getMemoryUsage ()
 {
  $ path = $ this-> getMemoryUsageVbsPath ();
  exec ("cscript -nologo $ path", $ usage);
  $ memory = json_decode ($ usage [0], true);
  $ memory ['usage'] = Round ((($ memory ['TotalVisibleMemorySize']-$ memory ['FreePhysicalMemory']) / $ memory ['TotalVisibleMemorySize']) * 100);
  return $ memory;
 }
}
