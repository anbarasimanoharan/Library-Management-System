package session;

/**
 * This class is intended to store all the properties of a session. Also, This class should be
 * accessible by all other classes.
 * 
 * @author anvesh
 * 
 */
public class Session {

  private static Session sInstance = null;
  private String username = null;

  // private String userId = null; //TODO: DO we need this. Ashwin, any ideas ?

  private String password = null;

  public String getUsername() {
    return username;
  }

  public void setUsername(String username) {
    this.username = username;
  }

  public String getPassword() {
    return password;
  }

  public void setPassword(String password) {
    this.password = password;
  }

  public int getTimeToLive() {
    return timeToLive;
  }

  public void setTimeToLive(int timeToLive) {
    this.timeToLive = timeToLive;
  }

  /**
   * This variable may only be used to implement time-outs in session. For all I know, this is not
   * part of the specifications doc so far.
   */
  private int timeToLive = 0;

  /**
   * Useful for implementing session-timeouts.
   */
  private boolean sessionStarted = false;

  public boolean isSessionStarted() {
    return sessionStarted;
  }

  public void setSessionStarted(boolean sessionStarted) {
    this.sessionStarted = sessionStarted;
  }

  private Session() {

  }

  public static synchronized Session getInstance() {
    if (sInstance == null) {
      // TODO: change the instance
      sInstance = new Session();
    }
    return sInstance;
  }

}
