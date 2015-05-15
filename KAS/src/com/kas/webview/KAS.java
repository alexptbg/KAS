package com.kas.webview;

import java.lang.reflect.Method;
import com.kas.webview.R;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences.OnSharedPreferenceChangeListener;
import android.content.SharedPreferences;
import android.content.res.Resources;
import android.preference.PreferenceManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.os.PowerManager;
import android.os.Vibrator;
import android.view.Gravity;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

/**
 * @author Alex Soares
 * 30 DEC 2013
 * alex@ka-ex.net
 * color: #2791D9
 * updated: April 2015
**/

    @SuppressLint("SetJavaScriptEnabled")
    public class KAS extends Activity implements OnSharedPreferenceChangeListener {
        WebView mWebView;
        
        TextView txtMessage1;
        TextView txtMessage2;
        
        SharedPreferences prefs;

        String SERIAL = this.getSerialNummer();
        String MAIN_ADD = "http://eesystems.net/kas/";

        ProgressBar loadingProgressBar,loadingTitle;

        private int NOTIFICATION_ID = 1;
        private Notification mNotification;
        private NotificationManager mNotificationManager;
        
        static boolean active = false;
        
        @Override
        public void onCreate(Bundle savedInstanceState) {
        	
            super.onCreate(savedInstanceState);
            //requestWindowFeature(Window.FEATURE_NO_TITLE); //remove titlebar
            setContentView(R.layout.main);
            
            txtMessage1 = (TextView)this.findViewById(R.id.txtCustomMsg1);
            txtMessage2 = (TextView)this.findViewById(R.id.txtCustomMsg2);
            
            prefs = PreferenceManager.getDefaultSharedPreferences(this);
            prefs.registerOnSharedPreferenceChangeListener(this);
            
            mNotificationManager = (NotificationManager) this.getSystemService(Context.NOTIFICATION_SERVICE);
            
            String USR = prefs.getString("USR", "USR");
            if(USR != null && !USR.equals("")) {   
            	//do something
            } else {
            	USR = "USR";
            }
            
            String PASSWD = prefs.getString("PASSWORD", "PASSWORD");
            if(PASSWD != null && !PASSWD.equals("")) {   
            	//do something
            } else {
            	PASSWD = "PASSWORD";
            }

            String lang = prefs.getString("language_preference", "");
            if(lang != null && !lang.equals("")) {   
            	//do something
            } else {
            	lang = "bg";
            }

            String AU = prefs.getString("notify_preference", "");
            if(AU != null && !AU.equals("")) {   
            	//do something
            } else {
            	AU = "standard";
            }
            //Log.d("Audio:",AU);
            
            mWebView = (WebView) findViewById(R.id.webview);
            mWebView.getSettings().setJavaScriptEnabled(true);
            mWebView.getSettings().setJavaScriptCanOpenWindowsAutomatically(false);
            mWebView.getSettings().setPluginsEnabled(true);
    	    mWebView.getSettings().setSupportZoom(true);
    	    mWebView.getSettings().setBuiltInZoomControls(true);
    	    mWebView.getSettings().setSupportMultipleWindows(false);
    	    mWebView.addJavascriptInterface(new WebAppInterface(this),"Android");
    	    //mWebView.getSettings().setUseWideViewPort(true);
    	    loadingProgressBar=(ProgressBar)findViewById(R.id.progressBar1);
    	    
            mWebView.setWebViewClient(new MyWebViewClient());
            String SYS = SERIAL;
            String URL = MAIN_ADD+"?lang="+lang+"&SYS="+SYS+"&USR="+USR+"&PWD="+PASSWD;
            
            //Log.d("Serial: ", SERIAL);
            
            mWebView.loadUrl(URL);
            
            if (savedInstanceState != null)
            	 ((WebView)findViewById(R.id.webview)).restoreState(savedInstanceState);
            
            mWebView.setWebChromeClient(new WebChromeClient() {
                // this will be called on page loading progress
                @Override
                public void onProgressChanged(WebView view, int newProgress) {
                    super.onProgressChanged(view, newProgress);
                    loadingProgressBar.setProgress(newProgress);
                    //loadingTitle.setProgress(newProgress);
                    //hide the progress bar if the loading is complete
                    if (newProgress == 100) {
                        loadingProgressBar.setVisibility(View.GONE);
                    } else {
                        loadingProgressBar.setVisibility(View.VISIBLE);
                    }
                }
            });

        }

        @Override
        protected void onSaveInstanceState(Bundle outState) {
            super.onSaveInstanceState(outState);
            mWebView.saveState(outState);
        }

        @Override
        protected void onRestoreInstanceState(Bundle savedInstanceState) {
            super.onSaveInstanceState(savedInstanceState);
            mWebView.restoreState(savedInstanceState);
        }
        
        public boolean onTouch(View v, MotionEvent event) {
            switch (event.getAction()) {
            case MotionEvent.ACTION_DOWN:
            case MotionEvent.ACTION_UP:
                if (!v.hasFocus()) {
                    v.requestFocus();
                }
                break;
            }
            return false;
        }
        
        @Override
        public boolean onKeyDown(int keyCode, KeyEvent event) {
            if(keyCode == KeyEvent.KEYCODE_BACK){
                finish();
            }
            return super.onKeyDown(keyCode, event);
        }

        @Override
        public void onStart() {
           super.onStart();
           active = true;
        } 

        @Override
        public void onStop() {
           super.onStop();
           active = false;
        }
        
        private class MyWebViewClient extends WebViewClient {
        	//extend options

            @Override
            public boolean shouldOverrideUrlLoading(WebView view, String url) {
                view.loadUrl(url);
                return true;
            }
            
        	//test splash screen
            @Override
            public void onPageFinished(WebView view, String url) {
                //hide
                //findViewById(R.id.splash).setVisibility(View.GONE);
                //show
                //findViewById(R.id.webview).setVisibility(View.VISIBLE);
            	final Handler handler = new Handler();
            	handler.postDelayed(new Runnable() {
            	  @Override
            	  public void run() {
                      //hide
                      findViewById(R.id.splash).setVisibility(View.GONE);
                      //show
                      findViewById(R.id.webview).setVisibility(View.VISIBLE);
            	  }
            	},1000);
            }

    		@Override
    		public void onReceivedError(WebView view, int errorCode, String description, String failingUrl) {
    			// if any error occured this message will be showed
    			/*Toast.makeText(PAS.this, 
    					"Error is occured, please try again..." + description, Toast.LENGTH_LONG).show(); */
    			//Log.e("Error", "onReceivedError = " + errorCode);
                view.loadUrl("file:///android_asset/error.html");
                AlertDialog.Builder builder = new AlertDialog.Builder(KAS.this);
                builder.setTitle(getString(R.string.error_69))
                    .setMessage(getString(R.string.error_int))
                    .setCancelable(false)
                    .setIcon(R.drawable.icon)
                    .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int id) {
                            KAS.this.finish();
                        }
                    });
                builder.create().show();
                Vibrator v = (Vibrator)getSystemService(Context.VIBRATOR_SERVICE);
                v.vibrate(500);
    		}
        }
		
        //called when user first clicks menu button
  	    @Override
  	    public boolean onCreateOptionsMenu(Menu menu) {
  		    MenuInflater inflater = getMenuInflater();
  		    inflater.inflate(R.menu.menu, menu);
  		    return true;
  	    }

  	    //called when an option is clicked
  	    @Override
  	    public boolean onOptionsItemSelected(MenuItem item) {
  	    	/*
  		    switch(item.getItemId()){
  		        case R.id.item_prefs:
  			    startActivity(new Intent(this, PrefsActivity.class));
  			    break;
  		    }
  		    return true;
  		    */
  	    	 switch (item.getItemId()) {
		         case R.id.item_prefs:
			     startActivity(new Intent(this, PrefsActivity.class));
			     break;
  		        
		         case R.id.item_exit:
  		         finish();
  		         System.exit(0);
  			     break;
  			     
  	    	     default:
  	    	     break;
  	    	}
  	    	return super.onOptionsItemSelected(item);
  	    }
  	
		@Override
		public void onSharedPreferenceChanged(SharedPreferences sharedPreferences,String key) {
			//txtMessage1.setText(prefs.getString("PIN", ""));
			//txtMessage2.setText(prefs.getString("PASSWORD", ""));
			Toast.makeText(KAS.this,KAS.this.getResources().getString(R.string.options_saved),
		    Toast.LENGTH_SHORT).show();

            prefs = PreferenceManager.getDefaultSharedPreferences(this);
            prefs.registerOnSharedPreferenceChangeListener(this);
            
            String USR = prefs.getString("USR", "USR");
            if(USR != null && !USR.equals("")) {   
            	//do something
            } else {
            	USR = "USR";
            }
            
            String PASSWD = prefs.getString("PASSWORD", "PASSWORD");
            if(PASSWD != null && !PASSWD.equals("")) {   
            	//do something
            } else {
            	PASSWD = "PASSWORD";
            }
            
            String lang = prefs.getString("language_preference", "");
            if(lang != null && !lang.equals("")) {   
            	//do something
            } else {
            	lang = "bg";
            }
            
            String AU = prefs.getString("notify_preference", "");
            if(AU != null && !AU.equals("")) {   
            	//do something
            } else {
            	AU = "standard";
            }
            
            String SYS = SERIAL;
			String URL = MAIN_ADD+"?lang="+lang+"&SYS="+SYS+"&USR="+USR+"&PWD="+PASSWD;
			mWebView.loadUrl(URL);
			//Log.d("restart", "true");
		}

	    public String getSerialNummer() {
	        String hwID = null;
	        try {
	            Class<?> c = Class.forName("android.os.SystemProperties");
	            Method get = c.getMethod("get", String.class, String.class);
	            hwID = (String) (get.invoke(c, "ro.serialno", "unknown"));
	        } catch (Exception ignored) {
	        }
	        if (hwID != null) return hwID;
	        try {
	            Class<?> myclass = Class.forName("android.os.SystemProperties");
	            Method[] methods = myclass.getMethods();
	            Object[] params = new Object[]{"ro.serialno", "Unknown"};
	            hwID = (String) (methods[2].invoke(myclass, params));
	        } catch (Exception ignored) {
	        }
	        return hwID;
	    }
	    //new version
	    public class WebAppInterface {
            
	        Context mContext;
	        /** Instantiate the interface and set the context */
	        WebAppInterface(Context c) {
	            mContext = c;
	        }
            
	        /** Show a toast from the web page */
	        @JavascriptInterface
	        public void showToast(String toast) {
	            //TOAST
                LayoutInflater inflater = getLayoutInflater();
                // Inflate the Layout
                View layout = inflater.inflate(R.layout.toast,(ViewGroup) findViewById(R.id.custom_toast_layout));
                TextView text = (TextView) layout.findViewById(R.id.textToShow);
                // Set the Text to show in TextView
                text.setText(toast);
                //TOAST START
                Toast t = new Toast(getApplicationContext());
                t.setGravity(Gravity.CENTER_VERTICAL,0,0);
                t.setDuration(Toast.LENGTH_LONG);
                t.setView(layout);
                t.show();
                Vibrator v = (Vibrator)getSystemService(Context.VIBRATOR_SERVICE);
                v.vibrate(500);
	        	//Toast.makeText(mContext,toast,Toast.LENGTH_SHORT).show();
	        }
	        
	        @JavascriptInterface
	        public void Notify(String toast) {
	            
	            //TOAST
                LayoutInflater inflater = getLayoutInflater();
                // Inflate the Layout
                View layout = inflater.inflate(R.layout.toast,(ViewGroup) findViewById(R.id.custom_toast_layout));
                TextView text = (TextView) layout.findViewById(R.id.textToShow);
                // Set the Text to show in TextView
                text.setText(toast);
                //TOAST START
                Toast t = new Toast(getApplicationContext());
                t.setGravity(Gravity.CENTER_VERTICAL,0,0);
                t.setDuration(Toast.LENGTH_LONG);
                t.setView(layout);
                t.show();
	        	//Toast.makeText(mContext,toast,Toast.LENGTH_SHORT).show();
	            if (active == true) {
	            	//Log.d("STATUS","ACTIVE");
	                Vibrator v = (Vibrator)getSystemService(Context.VIBRATOR_SERVICE);
	                v.vibrate(500);
	            } else {
	            	//Log.d("STATUS","INACTIVE");
		        	//WAKE UP
		        	final PowerManager pm = (PowerManager)mContext.getSystemService(Context.POWER_SERVICE);
		        	boolean isScreenOn = pm.isScreenOn();
		            if(isScreenOn==false) {
		                PowerManager.WakeLock wl = pm.newWakeLock(PowerManager.FULL_WAKE_LOCK|PowerManager.ACQUIRE_CAUSES_WAKEUP, "KAS");
		            	wl.acquire(1000);
		            	wl.release();
		            }
		            //SOUND
	                //Uri soundUri = RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION);
	                //Uri soundUri = Uri.parse("android.resource://" + mContext.getPackageName() + "/" + R.raw.alert);
	                String AU = prefs.getString("notify_preference", "");
	                Resources res = mContext.getResources();
	                int soundId = res.getIdentifier(AU,"raw",mContext.getPackageName());
	                Uri soundUri = Uri.parse("android.resource://" + mContext.getPackageName() + "/" + soundId);
	                
		        	//BACK INTENT
		            Intent targetIntent = new Intent(KAS.this,KAS.class);
		            targetIntent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP |Intent.FLAG_ACTIVITY_SINGLE_TOP);
		            PendingIntent contentIntent = PendingIntent.getActivity(KAS.this,0,targetIntent,PendingIntent.FLAG_UPDATE_CURRENT);
		            
		            //TOAST TEXT SPLIT
	                String note = toast;
	                String[] values = note.split(","); 
		            //NOTIFY
		            //Build the notification using Notification.Builder
		            Notification.Builder builder = new Notification.Builder(mContext)
		            .setSmallIcon(R.drawable.icon)
		            .setAutoCancel(true)
		            //.setDefaults(Notification.DEFAULT_SOUND)
		            .setSound(soundUri)
		            .setContentTitle(values[0])
		            .setContentText(values[1]);
		            builder.setContentIntent(contentIntent);
		            //Get current notification
		            mNotification = builder.getNotification();
		            long[] vibrate = {0,100,200,300,400,500};
		            mNotification.vibrate = vibrate;
		            mNotification.flags = Notification.FLAG_AUTO_CANCEL;
		            //Show the notification
		            mNotificationManager.notify(NOTIFICATION_ID,mNotification);
	            }
	        }
	        
	    }

    }
    //end
