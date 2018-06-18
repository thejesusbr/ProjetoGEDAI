package com.example.alunos.listadinmica;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;

public class EditaEvento extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.edita_evento);
    }

    public void proximaTela(View view){

        Intent intent = new Intent(this, EditaEvento.class);
        startActivity(intent);
    }
}
