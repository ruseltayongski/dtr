<?php
class BlogController extends Controller
{
    /**
     * Posts
     *
     * @return void
     */
    public function showPosts()
    {
        $posts = Post::paginate(5);
        if (Request::ajax()) {
            return Response::json(View::make('posts', array('cdo' => $posts))->render());
        }
        return View::make('blog', array('cdo' => $posts));

        /*Session::put('keyword',Input::get('keyword'));
        $keyword = Session::get('keyword');
        $cdo = post::where('approved_status',0)
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%");
            })
            ->orderBy('id','desc')
            ->paginate(2);
        return View::make('cdo.cdo_list',["cdo" => $cdo,"type" => $type]);*/
    }
}