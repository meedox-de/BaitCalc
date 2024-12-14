<?php
Yii::setAlias( '@common', dirname( __DIR__ ) );
Yii::setAlias( '@frontend', dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR . 'frontend' );
Yii::setAlias( '@backend', dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR . 'backend' );
Yii::setAlias( '@console', dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR . 'console' );
