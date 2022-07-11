<?php

namespace App\Http\Controllers;

use App\Bundles\Notifications\Application\CommentNotificator;
use App\Bundles\Notifications\Domain\Notification;
use App\Models\Activity;
use App\Models\Comment;
use App\Models\Roles;
use App\Notifications\NewComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function list($activity_id)
    {
        return Activity::findOrFail($activity_id)->comments->sortByDesc('id');
    }

    public function store(Request $request, CommentNotificator $notificator, $activity_id)
    {
        $comment = new Comment();
        $comment->comment = $request->get('comment');

        $comment->user()->associate(auth()->user());

        $model = Activity::find($activity_id);

        $notification = new Notification("Comment on {$model->name} | {$model->course->name}",
            substr(strip_tags($comment->comment), 0, 25) . '...',
            $model->topic_id,
            $activity_id
        );

        $notificator->sendToUsersWithRole(Roles::ADMIN, $notification);
        $notificator->sendToTeacherCourse($model->course, $notification);

        return $model->comments()->save($comment);
    }

    public function replies($activity_id, $parent_id) {
        return Comment::where('parent_id', $parent_id)->get();
    }

    public function storeReply(Request $request, $activity_id, $parent_id) {
        $comment = new Comment();
        $comment->comment = $request->get('comment');
        $comment->parent_id = $parent_id;

        $comment->user()->associate(auth()->user());
        $activity = Activity::find($activity_id);
        return $activity->comments()->save($comment);
    }

    public function delete(Request $request, $comment_id)
    {
        $comment = Comment::find($comment_id);
        $comment->delete();
    }
}
