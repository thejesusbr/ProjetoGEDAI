package com.example.alunos.listadinmica.adapter;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.alunos.listadinmica.R;
import com.example.alunos.listadinmica.model.Evento;

import java.util.List;

public class EventoAdapter extends BaseAdapter {

    private Activity atividade;
    private List<Evento> lista;

    public EventoAdapter(Activity atividade,List<Evento> lista){
        this.atividade = atividade;
        this.lista = lista;
    }
    @Override
    public int getCount(){
        return lista.size();
    }
    @Override
    public Object getItem(int position){
        return lista.get(position);
    }
    @Override
    public long getItemId(int position){
        return 0;
    }
    @Override
    public View getView(int position, View convertView, ViewGroup parent){
        Evento obj = lista.get(position);

        View v = atividade.getLayoutInflater().inflate(R.layout.row_layout,parent,false);

        TextView textnome = v.findViewById(R.id.lblFirst);
        textnome.setText(obj.getNome());

        TextView textData = v.findViewById(R.id.lblSecond);
        textData.setText(obj.getData());

        ImageView imgImagem = v.findViewById(R.id.imgImagem);
        imgImagem.setImageResource(obj.getImagem());

        return v;
    }
}
