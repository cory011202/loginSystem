<?php
  class inc_dataBase
  {
      //properties
      private $_userName = 'root';
      private $_passWord = 'FmintASS69';
      private $_hostName = 'localhost';
      private $_dataBase = 'loginSystem';
      private $_try;  
      //methods
      /*public function __construct($try)
      {
          $this->try = $try;
      } */
           
      public function connect()
      {   //Check to see if DB connection is open
          if(!$this->con)
          {   //perform connection it not connected
              $myConn = mysql_connect($this->_hostName,$this->_userName,$this->_passWord);
              if($myConn)
              {   //select DB if not connected
                  $selDb = mysql_select_db($this->_dataBase);
                  if($selDb)
                  {
                      $this->con = true;
                      return true;
                  } else
                  {
                      return false;
                  }
              } else
              {
                  return false;
              }              
          } else
          {
              return true;
          }         
      } 
  
      public function disConnect()
      {
          if($this->con)
          {
              if(mysql_close())
              {
                  $this->con = false;
                  return true;
              }else
              {
                  return false;
              }
          }
      }
      
       public function setTry($try)
      {
            $this->_try = $try;
      }
                  
      public function getTry()
      {
            return $this->_try;
      }
  
  
  
  }  
  
?>
