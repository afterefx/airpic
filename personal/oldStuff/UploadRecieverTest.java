package server;
 
import java.net.ServerSocket;
import java.net.Socket;
import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.FileOutputStream;
import java.io.File;
import java.io.Closeable;
import java.io.IOException;
 
class UploadReciever implements Closeable
{
  private final ServerSocket server;
  private final Socket clientSocket;
  private final BufferedInputStream in;
 
  private final int PORT;
  private final int BUFFER_SIZE;
  private final byte[] buffer;
 
  public UploadReciever(int PORT, int BUFFER_SIZE) throws IOException {
    this.PORT = PORT;
    this.BUFFER_SIZE = BUFFER_SIZE;
    this.buffer = new byte[BUFFER_SIZE];
    System.err.println("UploadReciever: Opening connection Listener on "+PORT+" ...");
    this.server = new ServerSocket(PORT);
    System.err.println("UploadReciever: Listening for client connections on "+PORT+" ...");
    this.clientSocket = server.accept();
    System.err.println("UploadReciever: Connected to client on port "+PORT);
    this.in = new BufferedInputStream(clientSocket.getInputStream());
    System.err.println("UploadReciever: Client-socket input stream is open.");
  }
 
  public int receive(File outputFile) throws IOException {
    System.err.println("UploadReciever.receive: Start!");
    int size = 0;
    BufferedOutputStream out = null;
    try {
      out = new BufferedOutputStream(new FileOutputStream(outputFile));
      System.err.println("UploadReciever.receive: File output stream is open.");
      int n = -1;
      System.err.println("UploadReciever.receive: reading buffers of "+BUFFER_SIZE+" bytes from client-socket ...");
      while ( (n=in.read(buffer)) != -1 ) {
        size += n;
        //System.err.print('r'); // slow!!!
        out.write(buffer, 0, n);
        //System.err.print('w'); // slow!!!
        //System.err.print(' '); // slow!!!
      }
      out.flush();
      System.err.println("\nUploadReciever.receive: Done! returning "+size);
    } finally {
      if(out!=null) out.close();
      System.err.println("UploadReciever.receive: File output stream is closed.");
    }
    return size;
  }
 
  public void close() throws IOException {
    try {
      if(in!=null) in.close();
    } finally {
      try {
        if(server!=null) server.close();
      } finally {
        if(clientSocket!=null) clientSocket.close();
      }
    }
  }
 
}
 
/** The is the server side of a file upload. i.e. Recieves a file from client. */
class UploadRecieverTest
{
  public static final int PORT = 9000;
  public static final int BUFFER_SIZE = 16*1024;
 
  public static void main(String[] args) {
    System.err.println("main: Start!");
    File outputFile = new File("test.txt");
    try {
      UploadReciever reciever = null;
      try {
        System.err.println("main: Opening reciever on "+PORT);
        reciever = new UploadReciever(PORT, BUFFER_SIZE);
        System.err.println("main: Reciever is open on "+PORT+". outputFile="+outputFile);
        int bytesReceived = reciever.receive(outputFile);
        System.err.println("main: Done! Received "+bytesReceived+" bytes.");
      } finally {
        if(reciever!=null) reciever.close();
        System.err.println("main: Receiver is closed.");
      }
      System.err.println("main: Success!");
    } catch (Exception e) {
      e.printStackTrace();
    }
    System.err.println("main: Done!");
    //System.console().readLine("Press enter to continue ...");
  }
 
}
