<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\UseCases\Event\EventDeleteUseCase;
use Illuminate\Http\RedirectResponse;

/**
 * イベント削除コントローラー
 *
 * イベントの削除に関連するアクションを提供するコントローラーです。
 */
class EventDeleteController extends Controller
{
    /**
     * イベント削除のビジネスロジックを提供するユースケース
     * 
     * @var EventDeleteUseCase イベント削除にに使用するUseCaseインスタンス
     */
    private $eventDeleteUseCase;

    /**
     * EventDeleteControllerのコンストラクタ。
     *
     * 使用するユースケースをインジェクション（注入）します。
     * 
     * @param EventDeleteUseCase $eventDeleteUseCase イベント削除に使用するUseCaseのインスタンス
     */
    public function __construct(EventDeleteUseCase $eventDeleteUseCase)
    {
        $this->eventDeleteUseCase = $eventDeleteUseCase;
    }

    /* =================== 以下メインの処理 =================== */

    /**
     * イベントを削除するメソッド
     *
     * 指定されたイベントを削除します。
     * 参加者がいる場合は削除できません。
     * 削除後は、ホームページにリダイレクトされます。
     *
     * @param int $event_id 削除対象のイベントID
     * @return RedirectResponse リダイレクトレスポンス
     */
    public function deleteEvent($event_id): RedirectResponse
    {
        $deleted = $this->eventDeleteUseCase->deleteEvent($event_id);

        if ($deleted) {
            return redirect()->route('index.home')->with('status', 'event-deleted');
        } else {
            return redirect()->route('event.show', ['event_id' => $event_id])->with('status', 'cannot-delete-event');
        }
    }
}
