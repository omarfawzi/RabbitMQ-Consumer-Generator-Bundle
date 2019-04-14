<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 4/13/2019
 * Time: 11:58 AM
 */

namespace ConsumerGenerator\Command;

use ConsumerGenerator\Model\ConsumerSkeleton;
use ConsumerGenerator\Service\GeneratorWrapper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

final class GeneratorCommand extends Command
{
    protected static $defaultName = 'consumer:generate';
    /** @var  GeneratorWrapper $generatorWrapper */
    protected $wrapper;

    public function __construct(GeneratorWrapper $wrapper)
    {
        parent::__construct(self::$defaultName);
        $this->wrapper = $wrapper;
    }

    protected function configure()
    {
        $this->setDescription('Generate consumers...')
            ->setHelp('This command allows you to generate consumers through command line...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generateAnotherConsumer = true;
        $consumers = [];
        $consumersPath = $this->requiredQuestion($input, $output, new Question('Enter Consumers Path : '));
        $consumersPath .= $this->requiredQuestion(
            $input,
            $output,
            new Question('Enter File Name (without extenstion) : ')
        );
        while ($generateAnotherConsumer) {
            $consumer = new ConsumerSkeleton();
            $consumer->setName(
                $this->requiredQuestion($input, $output, new Question('Please Enter The Consumer Name : '))
            );
            $consumer->setQueueRoutingKeys(
                $this->requiredQuestion(
                    $input,
                    $output,
                    new Question("Please Enter The Consumer Routing Keys separated by ',' : "),
                    true
                )
            );
            $consumer->setExchangeType(
                $this->requiredQuestion(
                    $input,
                    $output,
                    new ChoiceQuestion('Please Enter The Exchange Type : ', ['topic', 'direct', 'fanout', 'headers'])
                )
            );
            $consumer->setExchangeName(
                $this->requiredQuestion($input, $output, new Question('Please Enter The Exchange Name : '))
            );
            $consumer->setQueueName(
                $this->requiredQuestion($input, $output, new Question('Please Enter The Queue Name : '))
            );
            $consumer->setCallback(
                $this->requiredQuestion($input, $output, new Question('Please Enter The Path Of the Callback Class : '))
            );
            $consumer->setAmqpConsumerType(
                $this->requiredQuestion(
                    $input,
                    $output,
                    new ChoiceQuestion('Choose the type of consumer : ', ['consumers', 'batch_consumers'])
                )
            );
            $consumers[] = $consumer;
            $answer      = $this->requiredQuestion(
                $input,
                $output,
                new ChoiceQuestion('Generate Another Consumer ?', ['Yes', 'No'])
            );
            if ($answer == 'Yes') {
                $generateAnotherConsumer = true;
            } else {
                $generateAnotherConsumer = false;
            }
        }
        $this->wrapper->writeConsumers($consumers, $consumersPath);

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param mixed $question
     * @param bool $arrayAnswer
     *
     * @return mixed
     */
    private function requiredQuestion(
        InputInterface $input,
        OutputInterface $output,
        $question,
        bool $arrayAnswer = false
    ) {
        $helper = $this->getHelper('question');
        $result = null;
        if ($arrayAnswer && $question instanceof Question) {
            $question->setValidator(
                function ($answer) use ($output) : array {
                    $removedSpaces = str_replace(' ', '', $answer);
                    if (strpos($answer, ',') !== false) {
                        return explode(',', $removedSpaces);
                    }

                    return [$removedSpaces];

                }
            );
        }
        while (!isset($result)) {
            $result = $helper->ask($input, $output, $question);
        }

        return $result;
    }
}
