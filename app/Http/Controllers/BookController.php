<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BookController extends Controller
{
    public function index(){
        return view('book.index');
    }
    public function fetchAll(){
        $book = Book::all();
        $output ='';
        if($book->count()>0){
            $output .= '<table class="table table-bordered text-center">
            <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Year</th>
            <th scope="col">Note</th>
            <th scope="col">Image</th>
            <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>';
            foreach($book as $item){
                $formattedDate = date('d-M-Y', strtotime($item->year)); 
                $output .= '<tr>
                <td>'.$item->id.'</td>
                <td>'.$item->name.'</td>
                <td>'.$formattedDate.'</td>
                <td>'.$item->note.'</td>
                <td><img src="' . asset('images/uploads/' . $item->image) . '" height="50" width="50" class="img-thumbnail rounded-circle"></td>
                <td>
                <a href="#" id="' . $item->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editBookModal"><i class="bi-pencil-square h4"></i></a>
                <a href="#" id="' . $item->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
                
                </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        }else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }
    public function store(Request $request){
        $validateData = $request->validate([
            'name' => 'required',
            'year' => 'required',
            'note' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/uploads'), $imageName);
        $book = new Book([
            'name' => $validateData['name'],
            'year' => $validateData['year'],
            'note' => $validateData['note'],
            'image' => $imageName
        ]);
        $book->save();
        return response()->json([
            'status' => 200
        ]);
    }
    public function edit(Request $request){
        $id = $request->id;
        $book = Book::find($id);
        return response()->json($book);
    }
    public function update(Request $request){
        $delete = Book::find($request->id);
        if($request->has('image')){
            $image = $request->file('image');
            $oldImagePath = public_path('images/uploads/' . $delete->image);
            if($delete->image && file_exists($oldImagePath)){
                @unlink($oldImagePath);
            }
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/uploads'), $imageName);
        }else{
            $imageName = $delete->image;
        }
        $book = [
            'name' => $request->name,
            'year' => $request->year,
            'note' => $request->note,
            'image' => $imageName
        ];
        $delete->update($book);
        return response()->json([
            'status' => 200
        ]);
    }
    public function delete(Request $request){
        $id = $request->id;
        $book = Book::find($id);
        if(!$book){
            return response()->json([
                'status' => 404
            ]);
        }
        if($book->image){
            $oldImagePath = public_path('images/uploads/' . $book->image);
            if(file_exists($oldImagePath)){
                @unlink($oldImagePath);
            }
        }
        $book->delete();
        return response()->json([
            'status' => 200
        ]);
    }
}
