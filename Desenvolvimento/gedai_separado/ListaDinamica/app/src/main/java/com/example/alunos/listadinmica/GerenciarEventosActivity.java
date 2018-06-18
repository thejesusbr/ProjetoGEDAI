package com.example.alunos.listadinmica;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;

import static android.support.v4.content.ContextCompat.startActivity;

public class GerenciarEventosActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.edita_evento);
    }

    public void mandaMensagens(View v) {
        Intent it = new Intent(this, EditaEvento.class);
        Bundle bundle = new Bundle();
        it.putExtras(bundle);
        startActivity(it);
    }
}

