package utilities.log;


public class Log {

  static final boolean DEBUG_ENABLED = true;
  static ILog sInstance = null;
  static {
    if (DEBUG_ENABLED) {
      sInstance = new EnggLog();
    } else {
      sInstance = new UserLog();
    }
  }

  public static void d(String LOG_TAG, String msg) {
    sInstance.d(LOG_TAG, msg);
  }

  public static void i(String LOG_TAG, String msg) {
    sInstance.i(LOG_TAG, msg);
  }

  public static void w(String LOG_TAG, String msg) {
    sInstance.w(LOG_TAG, msg);
  }

  public static void e(String LOG_TAG, String msg) {
    sInstance.e(LOG_TAG, msg);
  }

  public static void p(String LOG_TAG, String msg) {
    sInstance.p("", msg);

  }


}


interface ILog {
  void d(String LOG_TAG, String msg);

  void i(String LOG_TAG, String msg);

  void w(String LOG_TAG, String msg);

  void e(String LOG_TAG, String msg);

  /**
   * The only purpose of this method is to print messages on to console in USER/ENGG binary.
   * 
   * @param LOG_TAG
   * @param msg
   */
  void p(String LOG_TAG, String msg);
}


class EnggLog implements ILog {

  @Override
  public void d(String LOG_TAG, String msg) {
    System.out.println(LOG_TAG + " : " + msg);
  }

  @Override
  public void i(String LOG_TAG, String msg) {
    System.out.println(LOG_TAG + " : " + msg);
  }

  @Override
  public void w(String LOG_TAG, String msg) {
    System.out.println(LOG_TAG + " : " + msg);
  }

  @Override
  public void e(String LOG_TAG, String msg) {
    System.out.println(LOG_TAG + " : " + msg);
  }

  @Override
  public void p(String LOG_TAG, String msg) {
    System.out.println(LOG_TAG + " : " + msg);

  }

}


class UserLog implements ILog {

  @Override
  public void d(String LOG_TAG, String msg) {
    // TODO Auto-generated method stub

  }

  @Override
  public void i(String LOG_TAG, String msg) {
    // TODO Auto-generated method stub

  }

  @Override
  public void w(String LOG_TAG, String msg) {
    System.out.println(LOG_TAG + " : " + msg);

  }

  @Override
  public void e(String LOG_TAG, String msg) {
    System.out.println(LOG_TAG + " : " + msg);

  }

  @Override
  public void p(String LOG_TAG, String msg) {
    System.out.println(LOG_TAG + " : " + msg);

  }

}
