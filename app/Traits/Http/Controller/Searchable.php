<?php


namespace App\Traits\Http\Controller;


use Illuminate\Http\Request;

trait Searchable
{
    public function search(Request $request)
    {
        abort_if(!method_exists('getModel', $this), "Please define method getModel");
        
        $this->validate($request, ['query' => 'required|string|max:255']);

        $model = $this->getModel();
        $this->authorize('search', $model);
        
        return response()->json(['result' => $model->search($request->get('query'))]);
    }
}