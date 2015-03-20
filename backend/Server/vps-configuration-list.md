###ubuntu开机自启动管理工具: `sysv-rc-conf`

  **To install:**
  
    sudo apt-get install sysv-rc-conf
    
  **To configure apache2 to start on boot**
  
    sysv-rc-conf apache2 on
    
  equivalent chkconfig command
  
    chkconfig apache2 enable
    
  **To check runlevels apache2 is configured to start on**
  
    sysv-rc-conf --list apache2
    
  equivalent chkconfig command
  
    chkconfig --list apache2

