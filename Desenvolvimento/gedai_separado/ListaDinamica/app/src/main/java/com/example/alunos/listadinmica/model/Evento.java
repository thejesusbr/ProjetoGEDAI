package com.example.alunos.listadinmica.model;

import android.os.Parcel;
import android.os.Parcelable;

public class Evento implements Parcelable{
    private String nome;
    private String data;
    private int imagem;

    protected Evento(Parcel in){
        nome = in.readString();
        data = in.readString();
        imagem = in.readInt();
    }

    public Evento(String nome, String data, int idImagem) {
        this.nome = nome;
        this.data = data;
        this.imagem = idImagem;
    }

    public String getNome(){
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getData(){
        return data;
    }

    public void setData(String data) {
        this.data = data;
    }

    public int getImagem(){
        return imagem;
    }

    public void setImagem(int id) {
        this.imagem = id;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeString(nome);
        dest.writeString(data);
        dest.writeInt(imagem);

    }
    @SuppressWarnings("unused")
    public static final Parcelable.Creator<Evento> CREATOR = new Parcelable.Creator<Evento>(){
        @Override
        public Evento createFromParcel(Parcel in){
            return new Evento(in);
        }
        @Override
        public Evento[] newArray(int size){
            return new Evento[size];
        }
    };
}