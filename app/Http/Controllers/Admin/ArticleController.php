<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.article.index', compact('articles'));
    }

    public function add()
    {
        return view('admin.article.add');
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'content' => 'required',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except(['image']);
            $data['status'] = $request->has('status') ? 1 : 0;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->extension();
                $destinationPath = public_path('uploads/articles');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $targetPath = $destinationPath . '/' . $name;
                
                // Process image with watermark and compression
                try {
                    $imageService = new \App\Services\ImageProcessingService();
                    $imageService->process($image->getPathname(), $targetPath, 75);
                } catch (\Exception $e) {
                    // Fallback: just move the file normally
                    $image->move($destinationPath, $name);
                }
                
                $data['image'] = 'uploads/articles/' . $name;
            }

            Article::create($data);

            return redirect()->route('admin.article.list')->with('success', 'Article created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function edit(Article $article)
    {
        return view('admin.article.edit', compact('article'));
    }

    public function editPost(Request $request, Article $article)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'content' => 'required',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except(['image']);
            $data['status'] = $request->has('status') ? 1 : 0;
            $data['slug'] = Str::slug($request->title); // Update slug on title change if needed

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($article->image && file_exists(public_path($article->image))) {
                    unlink(public_path($article->image));
                }
                
                $image = $request->file('image');
                $name = time() . '.' . $image->extension();
                $destinationPath = public_path('uploads/articles');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $targetPath = $destinationPath . '/' . $name;
                
                // Process image with watermark and compression
                try {
                    $imageService = new \App\Services\ImageProcessingService();
                    $imageService->process($image->getPathname(), $targetPath, 75);
                } catch (\Exception $e) {
                    // Fallback: just move the file normally
                    $image->move($destinationPath, $name);
                }
                
                $data['image'] = 'uploads/articles/' . $name;
            }

            $article->update($data);

            return redirect()->route('admin.article.list')->with('success', 'Article updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function delete(Article $article)
    {
        if ($article->image && file_exists(public_path($article->image))) {
            unlink(public_path($article->image));
        }
        $article->delete();
        return redirect()->route('admin.article.list')->with('success', 'Article deleted successfully!');
    }
}
