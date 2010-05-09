package server;

import java.net.*;
import java.io.*;
import java.util.Date;

public class FileClient
{
    public static void main (String [] args ) throws IOException 
    {
        // create socket
        ServerSocket server = new ServerSocket(13267);
        ClientWorker w; //client object

        //loop waiting for connection
        while (true) 
        {
            System.out.println("Waiting..."); 
            try
            {
                w = new ClientWorker(server.accept()); //create new client object
                Thread t = new Thread(w);//create thread
                t.start(); //start thread
            }
            catch(IOException e)
            {
                System.err.println("Caught error from thread.");
            }
        }
    }
}


