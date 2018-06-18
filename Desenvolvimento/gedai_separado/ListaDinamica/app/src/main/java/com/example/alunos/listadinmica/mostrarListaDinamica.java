package com.example.alunos.listadinmica;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.widget.ListView;

import com.example.alunos.listadinmica.adapter.EventoAdapter;
import com.example.alunos.listadinmica.model.Evento;

import java.util.ArrayList;

public class mostrarListaDinamica extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mostrar_lista_dinamica);

        ListView listview = findViewById(R.id.listview);

        Intent intent = getIntent();
        Bundle bundle = intent.getExtras();

        try{
            ArrayList<Evento> lista = bundle.getParcelableArrayList("contatos");
            EventoAdapter adapter = new EventoAdapter(mostrarListaDinamica.this,lista);
            listview.setAdapter(adapter);
        }catch (Exception e){
            Log.d(e.getClass().toString(),e.getMessage());
        }
    }
}
