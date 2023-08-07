<?php

namespace App\UseCases\Event;

use App\Models\Reaction;

/**
 * 
 */
class ReactionUseCase
{
    /**
     * 使用可能な絵文字の一覧を取得する
     *
     * @return array 絵文字の配列
     */
    public function getEmojis()
    {
        return [
            'face_and_persons' =>     [
                '🙂', '😀', '😃', '😄', '😁', '😅', '😆', '🤣', '😂', '🙃', '😉', '😊', '😇', '😎', '🧐',
                '🥳', '🥰', '😍', '🤩', '😙', '🥲', '😜', '🤪', '😝', '🤑', '🤗',
                '😒', '🙄', '😬', '😮‍💨', '🤥', '😪', '😴', '😌', '😔', '🤤', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '🥴', '😵',
                '🤯', '😕', '😟', '🙁', '☹', '😮', '😯', '😲', '😳', '🥺', '😦', '😧', '😨', '😰', '😥', '😢', '😭', '😱', '😖', '😣',
                '😞', '😓', '😩', '😫', '🥱', '😤', '😡', '😠', '🤬',  '💩',

            ],
            'emotions' =>     ['💖', '💗', '💕', '❣', '💔', '💯', '💢', '💥', '💫', '💦', '💬', '💤'],
            'tasks' => [
                '✅', '❌', '🎉', '👀', '🙏', '👍', '🙎', '🙎‍♂‍', '🙎‍♀‍', '🙅', '🙅‍♂‍', '🙅‍♀‍', '🙆', '🙆‍♂‍', '🙆‍♀‍', '💁', '💁‍♂‍',
                '💁‍♀‍', '🙋', '🙋‍♂‍', '🙋‍♀‍', '🙇', '🙇‍♂‍', '🙇‍♀‍', '🤷', '🤷‍♂‍', '🤷‍♀‍'
            ]
        ];
    }

    /**
     * ユーザーの反応（リアクション）を保存または削除します。
     *
     * @param int $userId
     * @param int $topicId
     * @param string $emoji
     * 
     * @return void
     */
    public function storeReaction(int $userId, int $topicId, string $emoji)
    {
        if (Reaction::hasReacted($userId, $topicId, $emoji)) {
            Reaction::where('user_id', $userId)
                ->where('topic_id', $topicId)
                ->where('emoji', $emoji)
                ->delete();
        } else {
            $reaction = new Reaction;
            $reaction->user_id = $userId;
            $reaction->topic_id = $topicId;
            $reaction->emoji = $emoji;
            $reaction->save();
        }
    }
}
