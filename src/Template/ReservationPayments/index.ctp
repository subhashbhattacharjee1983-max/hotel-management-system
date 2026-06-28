<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReservationPayment[]|\Cake\Collection\CollectionInterface $reservationPayments
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Reservation Payment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reservations'), ['controller' => 'Reservations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reservation'), ['controller' => 'Reservations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="reservationPayments index large-9 medium-8 columns content">
    <h3><?= __('Reservation Payments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reservation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment_price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bill_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment_method') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment_time') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservationPayments as $reservationPayment): ?>
            <tr>
                <td><?= $this->Number->format($reservationPayment->id) ?></td>
                <td><?= $reservationPayment->has('reservation') ? $this->Html->link($reservationPayment->reservation->id, ['controller' => 'Reservations', 'action' => 'view', $reservationPayment->reservation->id]) : '' ?></td>
                <td><?= $this->Number->format($reservationPayment->payment_price) ?></td>
                <td><?= h($reservationPayment->bill_type) ?></td>
                <td><?= h($reservationPayment->payment_method) ?></td>
                <td><?= h($reservationPayment->payment_date) ?></td>
                <td><?= h($reservationPayment->payment_time) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $reservationPayment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reservationPayment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reservationPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reservationPayment->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
