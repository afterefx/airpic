package client;
 
import java.net.Socket;
import java.net.SocketException;
import java.io.File;
import java.io.InputStream;
import java.io.FileInputStream;
import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.Closeable;
import java.io.FileNotFoundException;
import java.io.IOException;
 
class EchoListenerThread extends Thread
{
  private final InputStream input;
  private final byte[] buffer;
 
  public EchoListenerThread(InputStream input) {
    super.setDaemon(true); // close when the other thread does.
    super.setName("EchoListenerThread"); // appears in thread traces.
    this.input = input;
    this.buffer = new byte[1024];
  }
  public void run() {
    try {
      int n = -1;
      System.err.println("EchoListenerThread: reading ...");
      while ( (n=input.read(buffer)) != -1 ) {
        System.err.print("EchoListenerThread: MESSAGE FROM SERVER: ");
        System.err.write(buffer, 0, n);
      }
    } catch (java.net.SocketException e) {
      // do nothing. We get "SocketException: socket closed" when the main
      // thread closes the socket. Java NEEDS an interruptable read!
    } catch (IOException e) {
      e.printStackTrace();
    }
  }
}
 
class UploadSender implements Closeable
{
  private final Socket socket;
 
  private final int PORT;
  private final int BUFFER_SIZE;
  private final byte[] buffer;
 
  private final EchoListenerThread listener;
 
  private final BufferedOutputStream toServer;
 
  public UploadSender(int PORT, int BUFFER_SIZE) throws IOException {
    this.PORT = PORT;
    this.BUFFER_SIZE = BUFFER_SIZE;
    this.buffer = new byte[BUFFER_SIZE];
    System.err.println("UploadReciever: Connecting to server on port "+PORT+" ...");
    this.socket = new Socket("localhost", PORT);
    System.err.println("UploadSender: Connect to server on port "+PORT+" .");
    this.toServer = new BufferedOutputStream(socket.getOutputStream());
    System.err.println("UploadSender: Opened output stream to write to server.");
 
    System.err.println("UploadSender: Starting server listener thread ....");
    listener = new EchoListenerThread(socket.getInputStream());
    listener.start();
    System.err.println("UploadSender: server listener thread started.");
  }
 
  public int send(File inputFile) throws FileNotFoundException, IOException {
    int size = 0;
    long start = System.currentTimeMillis();
    System.err.println("UploadSender.send: Opened port "+PORT+" to server.");
    BufferedInputStream fIn = null;
    try {
      fIn = new BufferedInputStream(new FileInputStream(inputFile));
      int n = -1;
      while ( (n=fIn.read(buffer)) != -1 ) {
        size += n;
        toServer.write(buffer, 0, n);
        toServer.flush();
      }
    } finally {
      if(fIn!=null) fIn.close();
    }
    long end = System.currentTimeMillis();
    System.err.println("UploadSender.send: Done! Sent "+size+" bytes in "+(end-start)+" milliseconds");
    return size;
  }
 
  public void close() throws IOException {
    if(listener!=null) listener.interrupt();
    if(socket!=null) socket.close();
  }
 
}
 
/** The is the client side of a file upload. i.e. Send a file from client to server. */
public class UploadSenderTest
{
  public static void main(String[] args) {
    try {
      UploadSender sender = null;
      try {
        sender = new UploadSender(UploadRecieverTest.PORT, UploadRecieverTest.BUFFER_SIZE);
 
        // sender.send(new File("C:/Java/home/src/forums/PrimeTester_SieveOfPrometheuzz.txt")); // 27,256,113 bytes
        // Sent 27,256,113 bytes in 1,312 milliseconds
 
        sender.send(new File("C:/Java/home/src/forums/PrimeTester_SieveOfEratosthenes.txt")); // 259,678,799 bytes
        // BUFFER_SIZE  milliseconds
        // 8k           52,563  with "rw " message in server loop.
        // 8k           29,657  without "rw " message in server loop.
        // 16k          14,154
        // 32k          12,625
        // 64k          20,204
        // 128k         19,453
 
        // 32k          23,157
        // 32k          20,141
        // 32k          21,551
 
        // 16k          10,953
        // 16k          27,125
        // 16k          26,906
        // 16k          22,515
 
      } finally {
        if(sender!=null) sender.close();
      }
    } catch (Exception e) {
      e.printStackTrace();
    }
  }
}

