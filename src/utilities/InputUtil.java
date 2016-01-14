package utilities;

import java.util.Scanner;

import utilities.log.Log;

public class InputUtil {
  private static final String LOG_TAG = InputUtil.class.getSimpleName();
  private static InputUtil sInstance = null;

  public static synchronized InputUtil getInstance() {
    if (sInstance == null) {
      sInstance = new InputUtil();
    }
    return sInstance;
  }

  Scanner scanner = null;

  public InputUtil() {
    Log.d(LOG_TAG, "InputUtil instantiated!!");
    scanner = new Scanner(System.in);
  }

  public String getNextLineFromConsole() {
    String retVal = scanner.nextLine();
    if (retVal == null) {
      Log.e(LOG_TAG, "getNextLineFromConsole, null value while reading input from console.");
    }
    return retVal;
  }
}
