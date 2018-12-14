/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ejsfamilyhome;

import java.sql.*;
import javax.swing.JOptionPane;

/**
 *
 * @author Gezelle
 */
public class MyDBConnection {
    
  
    
public static Connection getConnection() {
    Connection con = null;
   try{           
      
       String url="jdbc:mysql://localhost:3306/ejsfamilyhome";
       String user="root";
       String pw="password";
        con =  DriverManager.getConnection(url, user, pw);    
       System.out.println("connected");
       
}
   catch(SQLException e){
       System.out.println(e.getMessage());
      JOptionPane.showMessageDialog(null,"Database connection failure.");
   }
   return con;
}


}
