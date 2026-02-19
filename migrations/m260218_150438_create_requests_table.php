<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%requests}}`.
 */
class m260218_150438_create_requests_table extends Migration
{
    public function up(): void
    {
        $this->createTable('{{%requests}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('id пользователя, подающего заявку'),
            'amount' => $this->integer()->notNull()->comment('сумма займа, которую пользователь запрашивает'),
            'term' => $this->integer()->notNull()->comment('срок займа в днях'),
            'status' => $this->string(20)->defaultValue('pending'),
            'is_approved' => $this->integer()->null()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx_requests_status', '{{%requests}}', 'status');
        $this->createIndex('idx_requests_is_approved', '{{%requests}}', ['user_id', 'is_approved'], true);
    }

    public function down(): void
    {
        $this->dropTable('{{%requests}}');
    }
}
