package com.kas.webview;

import com.kas.webview.R;

import android.os.Bundle;//as usual
import android.preference.PreferenceActivity;//instead of a regular Activity

/**
 * @author Alex Soares
 * 30 DEC 2013
 * alex@ka-ex.net
 * color: #2791D9
 * updated: April 2015
**/

public class PrefsActivity extends PreferenceActivity{ //instead of a regular Activity
	
	@Override
	public void onCreate(Bundle savedInstanceState){
		super.onCreate(savedInstanceState);
		addPreferencesFromResource(R.xml.prefs);//instead of setContentView()
	}

}

