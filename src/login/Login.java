package login;

import session.Session;
import utilities.InputUtil;
import utilities.log.Log;

/**
 * 
 * This class is the entry point to the library.
 * 
 * 
 * @author anvesh
 * 
 */
public class Login {

  private static final String LOG_TAG = Login.class.getSimpleName();
  InputUtil inputUtil = null;
  Session session = null;

  public Login() {
    inputUtil = InputUtil.getInstance();
    session = Session.getInstance();
  }

  public Credentials getCredentails() {
    String username = null, password = null;
    Log.p(LOG_TAG, "Please enter your UNITY ID");
    username = inputUtil.getNextLineFromConsole();
    Log.p(LOG_TAG, "Please enter your UNITY Password");
    password = inputUtil.getNextLineFromConsole();

    return new Credentials(username, password);
  }

  public void signin() {
    Credentials credentials = getCredentails();

    if (verifyCredentials(credentials)) {
      // TODO: Add db connectivity and verify credentials. Trivial Task only.

      session.setSessionStarted(true);
      session.setPassword(credentials.getPassword());
      session.setUsername(credentials.getUsername());

      // TODO: check retry logic and proceed.
    } else {
      // TODO: retry Logic goes here
    }

  }

  private boolean verifyCredentials(Credentials credentials) {
    return false;
    // TODO Auto-generated method stub

  }

  class Credentials {
    public String getUsername() {
      return username;
    }

    public String getPassword() {
      return password;
    }

    private String username;
    private String password;

    public Credentials() {}

    public Credentials(String username, String password) {
      this.username = username;
      this.password = password;
    }
  }
}
